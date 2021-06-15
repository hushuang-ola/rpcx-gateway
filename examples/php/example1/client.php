<?php
		$post = json_encode(array(
			"uids" => [100010097],
			"fields" => array(),
		));
		$_ch = curl_init();
        curl_setopt($_ch, CURLOPT_URL, 'http://127.0.0.1:9981/rpc/User.Profile/Mget');
        curl_setopt($_ch, CURLOPT_FOLLOWLOCATION, false);
        curl_setopt($_ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($_ch, CURLOPT_DNS_CACHE_TIMEOUT, 600);
        curl_setopt($_ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($_ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($_ch, CURLOPT_CONNECTTIMEOUT, 1);
        curl_setopt($_ch, CURLOPT_TIMEOUT, 3);
        curl_setopt($_ch, CURLOPT_HEADER, false);
        curl_setopt($_ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($_ch, CURLOPT_POST, 1);
        curl_setopt($_ch, CURLOPT_POSTFIELDS, $post);
        curl_setopt($_ch, CURLOPT_HEADER, 1);

        $header = array(
            "Content-type: application/rpcx",
            "X-RPCX-MessageID: 123456",
            "X-RPCX-MesssageType: 0",
            "X-RPCX-SerializeType: 1",
			"Content-Length: " . strlen($post),
			"Expect:"
        );
    
        curl_setopt($_ch, CURLOPT_HTTPHEADER, $header);
        $resp = curl_exec($_ch);
		$lastError = curl_error($_ch);

	    $headerSize = curl_getinfo($_ch, CURLINFO_HEADER_SIZE);
	    $header = substr($resp, 0, $headerSize);
		$body = substr($resp, $headerSize);

		curl_close($_ch);
		
		$map = array();
		preg_match_all("/(X\-Rpcx\-\S+): (.*?)\n/is", $header, $match);
		foreach($match[1] as $index => $key){
			$map[$key] = trim($match[2][$index]);
		}
		if(isset($map['X-Rpcx-Messagestatustype']) && $map['X-Rpcx-Messagestatustype'] == 'Error'){

		}
		print_r($match);
		print_r($body);
		echo "\n";

