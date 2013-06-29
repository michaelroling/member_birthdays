<?php

	$plugin_info       = array(
   	'pi_name'        => 'Member Birthdays',
   	'pi_version'     => '1.0',
   	'pi_author'      => 'Michael Roling',
   	'pi_author_url'  => 'http://www.michaelroling.com',
   	'pi_description' => 'This plugin returns an unordered list of member screennames whose birthday falls on the current day.',
	'pi_usage'          => Member_birthdays::usage()
   	
   	);
   
class Member_birthdays
{
	var $return_data = "";
	
  	function member_birthdays()
	{
		$this->EE =& get_instance();
		$this->return_data = $this->get_member_birthdays();
	}
	
	function get_member_birthdays()
	{
		$tdy = $this->EE->localize->set_localized_time();
		
		$dy = date("j",$tdy);
		$mth = date("n",$tdy);
		
		$query = $this->EE->db->query("
		SELECT *
		FROM `exp_members`
		WHERE bday_d = ? AND bday_m = ?",array($dy,$mth));
		
		$members = $query->result_array();
		
		$output = "<ul>\r\n";
		foreach($members as $member)
		{
			$output .= "<li>" . $member["screen_name"] . "</li>";
		}
		$output .= "\r\n</ul>";
		
        return $output;
	}
	
	function usage() {
		ob_start();
		?>
Member birthdays is a simple EE2 only plugin that returns an unordered list of member screennames whose birthday falls
on the current day.  This plugin uses member localization first but will fall back to server localization.
To use, simply upload /member_birthdays into system/expressionengine/third_party and use the following tag in a template:

{exp:member_birthdays}

That's it!  Enjoy!
		<?php
		$buffer = ob_get_contents();

		ob_end_clean();

		return $buffer;
	}	

}