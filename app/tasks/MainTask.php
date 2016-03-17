<?php

require dirname(__DIR__) . '/libraries/vendor/autoload.php';

class MainTask extends \Phalcon\CLI\Task
{
    public function mainAction() {
        
        $loop = React\EventLoop\Factory::create();
        $factory = new React\Datagram\Factory($loop);

		$factory->createServer('localhost:1234')->then(function (React\Datagram\Socket $server) {
		    
		    $server->on('message', function($message) {
		        
		          $version = unpack("n", substr($message, 0, 2));
		          
		          if ($version[1] == 5) {
		                
		                $v5_header_len = 24;
		                $v5_flowrec_len = 48;
		 
		          $header = unpack('nversion/ncount/Nsysuptime/Nunix_secs/Nunix_nsecs/Nflow_sequence/Cengine_type/Cengine_id/nsampling_interval', substr($message, 0, 24));
		          
		          $count = $header['count'];
		 
		          for ($i = 0; $i < $count; $i++) {

		    $flowrec = substr($message, $v5_header_len + ($i * $v5_flowrec_len), $v5_flowrec_len);

		    $flowdata = unpack('C4srcaddr/C4dstaddr/C4nexthop/ninput/noutput/NdPkts/NdOctets/NFirst/NLast/nsrcport/ndstport/Cblank/Ctcp_flags/Cprot/nsrc_as/ndst_as/Csrc_mask/Cdst_mask', $flowrec);
		                
		                 $srcaddr = array($flowdata['srcaddr1'],$flowdata['srcaddr2'],$flowdata['srcaddr3'],$flowdata['srcaddr4']);
		                 $dstaddr = array($flowdata['dstaddr1'],$flowdata['dstaddr2'],$flowdata['dstaddr3'],$flowdata['dstaddr4']);
		                 $impsrcaddr = implode('.', $srcaddr);
		                 $impdstaddr = implode('.', $dstaddr);

		                 $data  = [
					"netflow" => [
					"error" => true,  "error" => [
					"src ipAddr" => $impsrcaddr],[
					"code" => "src"]]];
    
                                echo json_encode($data),PHP_EOL;
		            } 
		         }
		    });
		});


	$loop->run();
    }
}
