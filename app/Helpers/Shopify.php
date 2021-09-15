<?php


namespace App\Helpers;


use GuzzleHttp\Client;

class Shopify
{
    protected $client;
    protected $version;
    protected $auth;


    public function __construct()
    {
        $this->client = new Client(['base_uri' => (config('shopify.base_uri'))]);
        $this->version = config('shopify.API_version');
        $this->auth = config('shopify.API_auth');
    }


//    public function getAllProducts($fields= null)
//    {
//        if ($fields){
//            $fields = implode(",",$fields);
//            $fields = "?fields=$fields";
//        }
//
////        $count = $this->client->get("/admin/api/$this->version/products/count.json", [
////            'auth' => $this->auth
////        ]);
//
////        return json_decode($count->getBody()->getContents(), false)->count;
//
//        // realize check is count more than 250 items
//
//        $request = $this->client->get("/admin/api/$this->version/products.json?limit=2&page_info=eyJsYXN0X2lkIjo1NjgzOTUwMjU2Mjg0LCJsYXN0X3ZhbHVlIjoi0JHQsNCz0LDQttC90LjQuiDQvdCwINGE0LDRgNC60L7QvyDQtNC70Y8g0L_QtdGA0LXQstC-0LfQutC4INCy0LXQu9C-0YHQuNC_0LXQtNC-0LIgVGh1bGUgVmVsb0NvbXBhY3QgMiA3LXBpbiA5MjUiLCJkaXJlY3Rpb24iOiJuZXh0In0".$fields, [
//            'auth' => $this->auth
//        ]);
//
//
//        return $request->getHeaders();
////        return json_decode($request->getBody()->getContents(), false)->products;
//    }

    protected function limitControl($responseHeaders)
    {
        $rateLimit = explode('/', $responseHeaders["X-Shopify-Shop-Api-Call-Limit"][0]);
        $usedLimitPercentage = (100 * $rateLimit[0]) / $rateLimit[1];
        if ($usedLimitPercentage > 95) {
            sleep(5);
        }
    }


    protected function response($fields,$nextPageToken)
    {
        $limit = config('shopify.rate_limit');
        $response = $this->client->get("/admin/api/$this->version/products.json?" . $fields . "&limit=" . $limit . "&page_info=".$nextPageToken, [
            'auth' => $this->auth
        ]);
        $responseHeaders = $response->getHeaders();
//        dd($responseHeaders);
        $tokenType = 'next';
        if (array_key_exists('Link', $responseHeaders)) {
            $link = $responseHeaders['Link'][0];
            $tokenType = strpos($link, 'rel="next') !== false ? "next" : "previous";
            $tobeReplace = ["<", ">", 'rel="next"', ";", 'rel="previous"'];
            $tobeReplaceWith = ["", "", "", ""];
            parse_str(parse_url(str_replace($tobeReplace, $tobeReplaceWith, $link), PHP_URL_QUERY), $op);
            $pageToken = trim($op['page_info']);
        }
//        $rateLimit = explode('/', $responseHeaders["X-Shopify-Shop-Api-Call-Limit"][0]);
//        $usedLimitPercentage = (100 * $rateLimit[0]) / $rateLimit[1];
//        if ($usedLimitPercentage > 95) {
//            sleep(5);
//        }
        $this->limitControl($responseHeaders);

        $r['resource'] = json_decode($response->getBody(), false)->products;
        $r[$tokenType]['page_token'] = isset($pageToken) ? $pageToken : null;
        return $r;
    }


    /**
     * Connects to shopify store and gets all products
     * @param array $fields
     * @return mixed
     */
    public function getAllProducts($fields= null)
    {
        if ($fields){
            $fields = implode(",",$fields);
            $fields = "fields=$fields";
        }
        $allProducts = [];
        $nextPageToken = null;
        do {
            $response = $this->response($fields, $nextPageToken);
            foreach($response['resource'] as $product) {
                $allProducts[] = $product;
            }
            $nextPageToken = $response['next']['page_token'] ?? null;
        }
        while($nextPageToken != null);
        return $allProducts;
    }



    /**
     * Connects to shopify store and gets one product
     * @param $id
     * @param null $fields
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getOneProduct($id, $fields = null)
    {
        if ($fields){
            $fields = implode(",",$fields);
            $fields = "?fields=$fields";
        }
        $request = $this->client->get("/admin/api/$this->version/products/$id.json".$fields, [
            'auth' => $this->auth
        ]);
        return json_decode($request->getBody()->getContents(), false)->product;
    }



    /**
     * Connects to shopify store and update product
     * @param $data
     * @return bool
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function updateProduct($data)
    {
        $id = $data['product']['id'];
        $response = $this->client->put("/admin/api/$this->version/products"."/$id".".json", [
            'auth' => $this->auth,
            'json' => $data
        ]);

        $responseHeaders = $response->getHeaders();
        $this->limitControl($responseHeaders);

        return $response->getStatusCode()== 200 ? true : false;
    }

}
