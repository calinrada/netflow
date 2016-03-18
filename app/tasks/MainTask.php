<?php

require dirname(__DIR__) . '/libraries/vendor/autoload.php';

class MainTask extends \Phalcon\CLI\Task
{
    public function mainAction() {
         
        echo "\n Decoding Netflow packets \n". PHP_EOL;
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
		 
	$header = 
		     'nversion/' .       # NetFlow export format version number
		     'ncount/' .         # Number of flows exported in this packet (1-30)
		     'Nsysuptime/' .     # Current time in milliseconds since the export device booted
		     'Nunix_secs/' .     # Current count of seconds since 0000 UTC 1970
		     'Nunix_nsecs/' .    # Residual nanoseconds since 0000 UTC 1970
		     'Nflow_sequence/' . # Sequence counter of total flows seen
		     'Cengine_type/' .   # Type of flow-switching engine
		     'Cengine_id/' .     # Slot number of the flow-switching engine
		     'nsampling_interval/'; # First two bits hold the sampling mode; remaining 14 bits hold value of sampling interval

        
        $unpack_header = unpack($header, substr($message, 0, 24));

		$count = $unpack_header['count'];
		 
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
    
		        $entryData = array(
			                 'category'   => 'FlowData'
			               , 'srcIp'      =>  $impsrcaddr
			               , 'dstIp'      =>  $impdstaddr 
			               , 'srcPort'    =>  $flowdata['srcport'],
			                 'dstPort'    =>  $flowdata['dstport']
                        );
                # ZeroMQ connection to our socket server and delivered a serialized message with the same information
			    $context = new ZMQContext();
			    $socket = $context->getSocket(ZMQ::SOCKET_PUSH, 'my pusher');
			    $socket->connect("tcp://localhost:5555");
			    $socket->send(json_encode($entryData));

		   } 
		 }
	  });
	});
    
    $loop->run();
    
   }
   
   public function VersionNineAction() {

         echo "\n Decoding Netflow v9 packets \n". PHP_EOL; 
   }
}
