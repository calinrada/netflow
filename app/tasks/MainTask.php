<?php

require dirname(__DIR__) . '/libraries/vendor/autoload.php';

class MainTask extends \Phalcon\CLI\Task
{
    public function mainAction() {
         

        echo "\n Decoding Netflow packets \n";
    
    }

    public function VersionFiveAction() {

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
		
		$header_format = 
                       'C4srcaddr/' .   # Source IP address
                       'C4dstaddr/' .   # Destination IP address
                       'C4nexthop/' .   # IP address of next hop router
                       'ninput/' .      # SNMP index of input interface
                       'noutput/' .     # SNMP index of output interface
                       'NdPkts/' .      # Packets in the flow
                       'NdOctets/' .    # Total number of Layer 3 bytes in the packets of the flow
                       'NFirst/' .      # SysUptime at start of flow
                       'NLast/' .       # SysUptime at the time the last packet of the flow was received
                       'nsrcport/' .    # TCP/UDP source port number or equivalent            
                       'ndstport/' .    # TCP/UDP destination port number or equivalent
                       'Cblank/' .      # TCP/UDP destination port number or equivalent
                       'Ctcp_flags/' .  # Cumulative OR of TCP flags
                       'Cprot/' .       # IP protocol type (for example, TCP = 6; UDP = 17)
                       'nsrc_as/' .     # Autonomous system number of the source, either origin or peer
                       'Csrc_mask/' .   # Source address prefix mask bits
                       'Cdst_mask';     # Destination address prefix mask bits
                /* Unpack the header data */
                $flowdata = unpack ($header_format, $flowrec);

		               
		        $srcaddr = array($flowdata['srcaddr1'],$flowdata['srcaddr2'],$flowdata['srcaddr3'],$flowdata['srcaddr4']);
		        $dstaddr = array($flowdata['dstaddr1'],$flowdata['dstaddr2'],$flowdata['dstaddr3'],$flowdata['dstaddr4']);
		        $impsrcaddr = implode('.', $srcaddr);
		        $impdstaddr = implode('.', $dstaddr);
		        $data  = ["netflow" => ["error" => true,  "error" => 
		                 ["src ipAddr" => $impsrcaddr],
		                 ["code" => "src"]]];
    
                              echo json_encode($data),PHP_EOL;
		       } 
		     }
		  });
	    });
    
    $loop->run();
    
   }
}
