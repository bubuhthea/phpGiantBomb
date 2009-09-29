<?php
/* phpGiantBomb Class
 * Written by Mike Horn (gpbmike@gmail.com)
 */
class phpGiantBomb {

    var $api_key;
    var $base_url = "http://api.giantbomb.com/";
    var $queries = array();
    var $cached = array();
    var $cache = false;
    var $cache_dir;
    
    function phpGiantBomb ($api_key)
    {
        $this->api_key = $api_key;
    }
    
    function query ($url, $fields = array(), $limit = 10)
    {
        $fields = array_merge(array('api_key' => $this->api_key, 'format' => 'json', 'limit' => $limit), $fields);
        $url = $this->base_url . $url . '?' . http_build_query($fields);
        $cache = $this->getCache($url);

        /* not using caching, or there isn't a cache */
        if ($this->cache == false || !$cache) {
            $this->queries[] = $url;
            $data = file_get_contents($url);
            if ($this->cache && $data) {
                $this->setCache($url, $data);
            }
            return json_decode($data);;
        }
        /* found cache to use */
        else {
            $this->cached[] = $url;
            return $cache;
        }
    }
    
    function enableCache ($cache_dir = false, $cache_expire = 600)
    {
        $this->cache = true;
		$this->cache_dir = realpath($cache_dir);
		if ($dir = opendir($this->cache_dir)) {
			while ($file = readdir($dir)) {
				if (substr($file, -6) == '.cache' && ((filemtime($this->cache_dir . '/' . $file) + $cache_expire) < time()) ) {
					unlink($this->cache_dir . '/' . $file);
				}
			}
		}    
    }
    
    function getCache ($request)
    {
        if (!$this->cache) { return false; }
        $reqhash = md5(serialize($request));
		$file = $this->cache_dir . '/' . $reqhash . '.cache';
		if (file_exists($file)) {
			return json_decode(file_get_contents($file));
		}
		return false;
    }
    
    function setCache ($request, $response)
    {
        if (!$this->cache) { return false; }
        $reqhash = md5(serialize($request));
        $file = $this->cache_dir . "/" . $reqhash . ".cache";
		$fstream = fopen($file, "w");
		$result = fwrite($fstream, $response);
		fclose($fstream);
		return $result;
    }
    
    function accessory ($id)
    {
        $fields = array();
        return $this->query('accessory/' . (int)$id . '/', $fields);
    }
    
    function accessories ()
    {
        $fields = array();
        return $this->query('accessories/', $fields);
    }
    
    function character ($id)
    {
        $fields = array();
        return $this->query('character/' . (int)$id . '/', $fields);
    }
    
    function characters ()
    {
        $fields = array();
        return $this->query('characters/', $fields);
    }
    
    function company ($id)
    {
        $fields = array();
        return $this->query('company/' . (int)$id . '/', $fields);
    }
    
    function companies ()
    {
        $fields = array();
        return $this->query('companies/', $fields);
    }
    
    function concept ($id)
    {
        $fields = array();
        return $this->query('concept/' . (int)$id . '/', $fields);
    }
    
    function concepts ()
    {
        $fields = array();
        return $this->query('concepts/', $fields);
    }
    
    function franchise ($id)
    {
        $fields = array();
        return $this->query('franchise/' . (int)$id . '/', $fields);
    }
    
    function franchises ()
    {
        $fields = array();
        return $this->query('franchises/', $fields);
    }
    
    function game ($id)
    {
        $fields = array();
        return $this->query('game/' . (int)$id . '/', $fields);
    }
    
    function games ()
    {
        $fields = array();
        return $this->query('games/', $fields);
    }
    
    function game_rating ($id)
    {
        $fields = array();
        return $this->query('game_rating/' . (int)$id . '/', $fields);
    }
    
    function game_ratings ()
    {
        $fields = array();
        return $this->query('game_ratings/', $fields);
    }
    
    function genre ($id)
    {
        $fields = array();
        return $this->query('genre/' . (int)$id . '/', $fields);
    }
    
    function genres ()
    {
        $fields = array();
        return $this->query('genres/', $fields);
    }
    
    function location ($id)
    {
        $fields = array();
        return $this->query('location/' . (int)$id . '/', $fields);
    }
    
    function locations ()
    {
        $fields = array();
        return $this->query('locations/', $fields);
    }
    
/*
    function object ($id)
    {
        $fields = array();
        return $this->query('object/' . (int)$id . '/', $fields);
    }
    
    function objects ()
    {
        $fields = array();
        return $this->query('objects/', $fields);
    }
*/
    
    function person ($id)
    {
        $fields = array();
        return $this->query('person/' . (int)$id . '/', $fields);
    }
    
    function people ()
    {
        $fields = array();
        return $this->query('people/', $fields);
    }
    
    function platform ($id)
    {
        $fields = array();
        return $this->query('platform/' . (int)$id . '/', $fields);
    }
    
    function platforms ()
    {
        $fields = array();
        return $this->query('platforms/', $fields);
    }
    
    function rating_board ($id)
    {
        $fields = array();
        return $this->query('rating_board/' . (int)$id . '/', $fields);
    }
    
    function rating_boards ()
    {
        $fields = array();
        return $this->query('rating_boards/', $fields);
    }
    
    function region ($id)
    {
        $fields = array();
        return $this->query('region/' . (int)$id . '/', $fields);
    }
    
    function regions ()
    {
        $fields = array();
        return $this->query('regions/', $fields);
    }
    
    function release ($id)
    {
        $fields = array();
        return $this->query('release/' . (int)$id . '/', $fields);
    }
    
    function releases ()
    {
        $fields = array();
        return $this->query('releases/', $fields);
    }
    
    function review ($id)
    {
        $fields = array();
        return $this->query('review/' . (int)$id . '/', $fields);
    }
    
    function reviews ()
    {
        $fields = array();
        return $this->query('reviews/', $fields);
    }
    
    function search ($query)
    {
        $fields = array(
            'query' => $query );
        return $this->query('search/', $fields);
    }
    
    function theme ($id)
    {
        $fields = array();
        return $this->query('theme/' . (int)$id . '/', $fields);
    }
    
    function themes ()
    {
        $fields = array();
        return $this->query('themes/', $fields);
    }
    
    function type ($id)
    {
        $fields = array();
        return $this->query('type/' . (int)$id . '/', $fields);
    }
    
    function types ()
    {
        $fields = array();
        return $this->query('types/', $fields);
    }
    
    function user_review ($id)
    {
        $fields = array();
        return $this->query('user_review/' . (int)$id . '/', $fields);
    }
    
    function user_reviews ()
    {
        $fields = array();
        return $this->query('user_reviews/', $fields);
    }
    
    function video ($id)
    {
        $fields = array();
        return $this->query('video/' . (int)$id . '/', $fields);
    }
    
    function videos ()
    {
        $fields = array();
        return $this->query('videos/', $fields);
    }

}

?>