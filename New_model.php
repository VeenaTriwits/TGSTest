<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class New_model extends CI_Model
{
	public function searchEducationBased($id){
    $string = str_replace('%20', ' ', $id);
  // $query=$this->db->where('scholarship_type',$string)->where('application_end_date >=', date('Y-m-d'))->Where('web_status',1)->order_by('application_end_date','ASC')->get('scholarships')->result();
 $query=$this->db->where('scholarship_type',$string)->where('application_end_date >=', date('Y-m-d'))->Where('web_status',1)->order_by('scholarship_added_date','DESC')->get('scholarships')->result();
 //$query=$this->db->where('scholarship_type',$string)->Where('web_status',1)->order_by('scholarship_added_date','DESC')->get('scholarships')->result();
      return $query;     
  }
  /*=====================To add Expired Schloar shop List ================================*/
  /*public function expired(){

   $query=$this->db->where('application_end_date <', date('Y-m-d'))->Where('web_status',1)->order_by('application_end_date','ASC')->get('scholarships')->result();

   $query=$this->db->where('application_end_date <', date('Y-m-d'))
                    ->where('application_end_date >',date("Y-m-d H:i:s",strtotime("-1 month")))
                    ->Where('web_status',1)
                    ->order_by('application_end_date','DESC')
                  ->get('scholarships')->result();
      return $query;     
  } */

  public function expired()
{
    $query = $this->db->where('application_end_date <', date('Y-m-d'))
                    ->where('application_end_date >', date("Y-m-d H:i:s", strtotime("-1 month")))
                    ->where('YEAR(application_end_date)', 2023) // Add this condition
                    ->where('web_status', 1)
                    ->order_by('application_end_date', 'DESC')
                    ->get('scholarships')
                    ->result();
    return $query;
}
public function expired2024()
{
    $query = $this->db->where('application_end_date <', date('Y-m-d'))
                    ->where('application_end_date >', date("Y-m-d H:i:s", strtotime("-1 month")))
                    ->where('YEAR(application_end_date)', 2024)
                    ->where('web_status', 1)
                    ->order_by('application_end_date', 'DESC')
                    ->get('scholarships')
                    ->result();
    return $query;
}

  
   /*=====================Code for filter option on 21 July By varun ================================*/
public function filterbycourse($course,$search)
    {
         // New_model.php


       /* $query = $this->db->where('scholarship_type', 'Scholarship')
                          ->where('application_end_date >=', date('Y-m-d'))
                          ->where("CONCAT(',', courses, ',') LIKE '%$course%'")
                          ->order_by('scholarship_added_date', 'DESC')
                          ->get('scholarships')
                          ->result();
        return $query;*/
        $this->db->where('scholarship_type', $search);
$this->db->where('application_end_date >=', date('Y-m-d'));
$this->db->order_by('scholarship_added_date', 'DESC');

// Fetch all scholarships
$scholarships = $this->db->get('scholarships')->result();

// Initialize an array to store filtered scholarships
$filteredScholarships = [];

// Loop through all scholarships
foreach ($scholarships as $scholarship) {
    $courses = json_decode($scholarship->courses, true);

    // If the provided course is in the scholarship courses or "ALL" is the default, include it in the filtered scholarships
    if (in_array($course, $courses) || in_array("All", $courses)) {
        $filteredScholarships[] = $scholarship;
    }
}

// Return the filtered scholarships
return $filteredScholarships;

    }

  public function getCourse()
    {

        $result=$this->db->query("select * from  courses order by id asc");
  // $this->db->select('*')->from('courses')->get()->result();
  // print_r($result);exit()
  // $result=$this->db->get('states');
        return $result;
    }
    /*=====================Code for filter option on 21 July By varun ================================*/

 /* ------------------for sitemap---------on 08 June------by varun----------*/
  public function getallforsitemap(){
   $query=$this->db->where('application_end_date >=', date('Y-m-d'))
                   ->order_by('scholarship_added_date','DESC')
                   ->get('scholarships')->result();
      return $query;     
  }


  public function searchAbroadscholarshipforsitemap(){
  
 $query=$this->db->where('scholarship_type','Abroad')->where('application_end_date >=', date('Y-m-d'))->Where('web_status',1)->order_by('scholarship_added_date','DESC')->get('scholarships')->result();
      return $query;     
  }
  public function searchscholarshipforsitemap(){
  
 $query=$this->db->where('scholarship_type','Scholarship')->where('application_end_date >=', date('Y-m-d'))->Where('web_status',1)->order_by('scholarship_added_date','DESC')->get('scholarships')->result();
      return $query;     
  }
  public function serachOtherScholarshipforsitemap(){
  
   // print_r($string);exit;
    $query=$this->db->where('scholarship_type !=','Scholarship')->where('scholarship_type !=','Abroad')->where('application_end_date >=', date('Y-m-d'))->Where('web_status',1)->limit(12)->get('scholarships')->result();
    return $query;     
  }
  /* ------------------10 June------by varun----------*/
  public function foronefeedbackaday($studentEmail)
  {
    $string = $studentEmail;
  
   // print_r($string);exit;

    $query=$this->db->where('student_email',$string)->where('feedback_date >= ', date('Y-m-d H:i:s'))->Where('web_status',0)->get('feed_back');
       
     if($query->num_rows() > 0){
        echo '<script> alert("Only one feedback is allowed for a day")</script>';
    return TRUE;     
  }
    else 
    {
    return FALSE;
    }
  }
    /* ------------------10 June------by varun----------*/
  
   /* ------------------for sitemap---------on 08 June------by varun----------*/

  public function filtersearchEducationBased($id,$limit,$start){
    $string = str_replace('%20', ' ', $id);
    $nostring = str_replace('%20', ' ', $nid);
    $this->db->limit($limit, $start);
    $query=$this->db->where('application_end_date >=', date('Y-m-d'))->where('scholarship_type!=', 'Abroad')->Where('web_status',1)->order_by('scholarship_type','DESC')->order_by('application_end_date','ASC')->get('scholarships')->result();
//$query=$this->db->where('application_end_date >=', date('Y-m-d'))->where('scholarship_type!=', 'Abroad')->Where('web_status',1)->order_by('scholarship_type','DESC')->order_by('application_start_date','DESC')->get('scholarships')->result(); // 13th may update

    return $query;     
  }
   public function filterAbroadsearchEducationBased($id,$limit,$start){
    $string = str_replace('%20', ' ', $id);
    $nostring = str_replace('%20', ' ', $nid);
    $this->db->limit($limit, $start);
    $query=$this->db->where('application_end_date >=', date('Y-m-d'))->where('scholarship_type!=', 'Competitions and Awards')->Where('web_status',1)->order_by('scholarship_type','ASC')->order_by('application_end_date','ASC')->get('scholarships')->result();
   //$query=$this->db->where('application_end_date >=', date('Y-m-d'))->where('scholarship_type!=', 'Competitions and Awards')->Where('web_status',1)->order_by('application_start_date','DESC')->get('scholarships')->result();

     return $query;     
  }
    public function filterCompetitionssearchEducationBased($id,$limit,$start){
    $string = str_replace('%20', ' ', $id);
    $nostring = str_replace('%20', ' ', $nid);
    $this->db->limit($limit, $start);
    $query=$this->db->where('application_end_date >=', date('Y-m-d'))->where('scholarship_type!=','Abroad')->Where('web_status',1)->order_by('scholarship_type','ASC')->order_by('application_end_date','ASC')->get('scholarships')->result();
    return $query;     
  }
  public function get_scholarship_count($id) 
{
  $string = str_replace('%20', ' ', $id);
  return $this->db->where('application_end_date >=', date('Y-m-d'))->where('scholarship_type!=', $string)->get("scholarships")->num_rows();

}
  public function serachOtherScholarship($id){
    $string = str_replace('%20', ' ', $id);
   // print_r($string);exit;
    $query=$this->db->where('scholarship_type',$string)->where('scholarship_type !=','')->where('application_end_date >=', date('Y-m-d'))->Where('web_status',1)->limit(12)->get('scholarships')->result();
    return $query;     
  }/*
  public function getScholarshipDetails($id){
   $this->db->select('*');
   $this->db->from('scholarships');
   // $this->db->join('scholarship_attachment','scholarship_attachment.scholarship_id = scholarships.scholarship_id');
   $this->db->where('scholarships.scholarship_id',$id);
   $query = $this->db->get();
   return $query->row();
 }*/
 public function getCategorizeScholarships($offset, $limit,$id)
{
    $string = str_replace('%20', ' ', $id);
    
    $this->db->where('scholarship_type', $string)->where('scholarship_type !=','')
             ->where('application_end_date >=', date('Y-m-d'))->Where('web_status',1)
             ->limit($limit, $offset);
    $query =$this->db->get('scholarships');
    return $query->result();
}

public function getScholarshipDetails($id){
   $this->db->select('*');
   $this->db->from('scholarships');
   // $this->db->join('scholarship_attachment','scholarship_attachment.scholarship_id = scholarships.scholarship_id');
   $this->db->where('scholarships.scholarship_id',$id);
   $query = $this->db->get();
   return $query->row();
 }



  public function someOtherScholarship($id){
    $string = str_replace('%20', ' ', $id);
    $query=$this->db->where('scholarship_type !=',$string)->where('scholarship_type !=','')->where('application_end_date >=', date('Y-m-d'))->limit(3)->get('scholarships')->result();
    return $query;     
  }

    public function internshipScholarship(){
    $query=$this->db->where('scholarship_type','Internship')->where('scholarship_type !=','')->where('application_end_date >=', date('Y-m-d'))->limit(3)->get('scholarships')->result();
    return $query;     
  }
  public function getScholarshipAttachment($id){
    //print_r('iii');exit;
    $this->db->where('scholarship_id',$id);
    $query = $this->db->get('scholarship_attachment');
      return $query;
    }
  public function getPushNotification(){
      $this->db->select('push.*')
      ->from('sent_notifications push');
      $data=$this->db->get();
      return $data;
  }
  public function getPushAmount(){
      $notification=$this->getPushNotification();
      $amount=0;
      if($notification->num_rows() > 0){
         foreach($notification->result() as $notif){
             $scholarship=$this->db->where('scholarship_id',$notif->scholarship_id)->get('scholarships')->row();
            
                $amount+=$scholarship->scholarship_worth;
            
         }
        
      }
       //print_r($amount);exit;
       return $amount;
  }
function moneyFormatIndia($num) {
    
    $explrestunits = "" ;
    if(strlen($num)>3) {
       
        $lastthree = substr($num, strlen($num)-3, strlen($num));
        $restunits = substr($num, 0, strlen($num)-3); // extracts the last three digits
        $restunits = (strlen($restunits)%2 == 1)?"0".$restunits:$restunits; // explodes the remaining digits in 2's formats, adds a zero in the beginning to maintain the 2's grouping.
        $expunit = str_split($restunits, 2);
        for($i=0; $i<sizeof($expunit); $i++) {
            // creates each of the 2's group and adds a comma to the end
            if($i==0) {
                $explrestunits .= (int)$expunit[$i].","; // if is first value , convert into integer
            } else {
                $explrestunits .= $expunit[$i].",";
            }
        }
        $thecash = $explrestunits.$lastthree;
    } else {
        $thecash = $num;
    }
    return $thecash;
     print_r($thecash);exit;
}


public function countMatchingScholarships($studentUsername) {
    // Step 1: Fetch student qualifications
    $this->db->select('qualification');
    $this->db->where('student_username', $studentUsername);
    $qualificationsQuery = $this->db->get('student_academic_details');
    
    // Step 2: Extract student qualifications as an array
    $studentQualifications = array();
    foreach ($qualificationsQuery->result() as $row) {
        $studentQualifications[] = $row->qualification;
    }

    // Step 3: Query scholarships that match qualifications
    $this->db->where('application_end_date >=', date('Y-m-d'));

    // Fetch all scholarships
    $scholarships = $this->db->get('scholarships')->result();

    // Initialize a count variable
    $matchingCount = 0;

    // Loop through all scholarships
    foreach ($scholarships as $scholarship) {
        $courses = json_decode($scholarship->courses);

        // Check if $courses is an array before using in_array()
        if (is_array($courses) && (in_array("All", $courses) || count(array_intersect($studentQualifications, $courses)) > 0)) {
            $matchingCount++;
        }
    }

    return $matchingCount;
}
 public function getScholarshipsWithNullStatus($studentUsername) {
    $this->db->where('student_username', $studentUsername);
    $this->db->where('applied_status', null);
    $query = $this->db->get('scholarship_logs');
    return $query->result();
}
public function countAppliedScholarships($studentUsername) {
    // Assuming you have a table called 'scholarship_log' with 'applied_status' column
    $this->db->where('student_username', $studentUsername);
    $this->db->where('applied_status', 'applied');
    $count = $this->db->count_all_results('scholarship_logs');
    return $count;
}


public function sumAppliedScholarshipsWorth($studentUsername) {
    // Get the scholarships that have been applied by the student
    $this->db->select('scholarship_id');
    $this->db->where('student_username', $studentUsername);
    $this->db->where('applied_status', 'applied');
    $appliedScholarships = $this->db->get('scholarship_logs')->result();

    $totalWorth = 0;

    foreach ($appliedScholarships as $appliedScholarship) {
        $this->db->select('scholarship_worth');
        $this->db->where('scholarship_id', $appliedScholarship->scholarship_id);
        $worth = $this->db->get('scholarships')->row()->scholarship_worth;

        $totalWorth += $worth;
    }

    return $totalWorth;
}


public function sumMatchingScholarshipsWorth($studentUsername) {
    // Initialize the sum variable
    $matchingScholarshipsWorth = 0;

    // Query matching scholarships based on student qualifications and application end date
    $this->db->select('qualification');
    $this->db->where('student_username', $studentUsername);
    $qualificationsQuery = $this->db->get('student_academic_details');
    $studentQualifications = array();

    foreach ($qualificationsQuery->result() as $row) {
        $studentQualifications[] = $row->qualification;
    }

    // Fetch scholarships that meet the application end date condition
    $this->db->where('application_end_date >=', date('Y-m-d'));
    $scholarships = $this->db->get('scholarships')->result();

    // Loop through scholarships to calculate the sum
    foreach ($scholarships as $scholarship) {
        if (!is_null($scholarship->courses)) {
            $courses = json_decode($scholarship->courses);

            // Check if $courses is an array before using in_array()
            if (is_array($courses) && (in_array("All", $courses) || count(array_intersect($studentQualifications, $courses)) > 0)) {
                $matchingScholarshipsWorth += $scholarship->scholarship_worth;
            }
        }
    }

    return $matchingScholarshipsWorth;
}





public function hasNullStatusScholarship($studentUsername) {
        $this->db->where('student_username', $studentUsername);
        $this->db->where('applied_status', NULL);
        $query = $this->db->get('scholarship_logs');
        return ($query->num_rows() > 0);
    }


public function getallscholarships(){
  $query=$this->db->where('application_end_date >=', date('Y-m-d'))->Where('web_status',1)->order_by('scholarship_added_date','DESC')->get('scholarships')->result();
      return $query;     
  }
public function getmatchedScholarships()
{
   /* $studentUsername = 'RujRAQsPrVXDbFBWCE';*/
    $studentUsername = $this->session->userdata('student_username');
    $selectedType = 'Scholarship';

    // Step 1: Fetch student qualifications
    $this->db->select('qualification');
    $this->db->where('student_username', $studentUsername);
    $qualificationsQuery = $this->db->get('student_academic_details');
    
    // Step 2: Extract student qualifications as an array
    $studentQualifications = array();
    foreach ($qualificationsQuery->result() as $row) {
        $studentQualifications[] = $row->qualification;
    }

    // Step 3: Query scholarships that match qualifications
    $this->db->where('application_end_date >=', date('Y-m-d'));
    $this->db->where('scholarship_type', $selectedType);
    $this->db->order_by('scholarship_added_date', 'DESC');
    

    // Fetch all scholarships
    $scholarships = $this->db->get('scholarships')->result();

    // Initialize an array to store filtered scholarships
    $filteredScholarships = array();

    // Loop through all scholarships
    foreach ($scholarships as $scholarship) {
        $courses = json_decode($scholarship->courses);

        // Check if $courses is an array before using in_array()
        if (is_array($courses) && (in_array("All", $courses) || count(array_intersect($studentQualifications, $courses)) > 0)) {
            $filteredScholarships[] = $scholarship;
        }
    }

    // Return the filtered scholarships
    return $filteredScholarships;
}

/* START Updated code on 10 Jan 24 By Varun */

public function getmatchedScholarshipsontype($selectedType)
{
   /* $studentUsername = 'QnQS1Bk9UH38';*/
    $studentUsername = $this->session->userdata('student_username');

    // Step 1: Fetch student qualifications
    $this->db->select('qualification');
    $this->db->where('student_username', $studentUsername);
    $qualificationsQuery = $this->db->get('student_academic_details');
    
    // Step 2: Extract student qualifications as an array
    $studentQualifications = array();
    foreach ($qualificationsQuery->result() as $row) {
        $studentQualifications[] = $row->qualification;
    }

    // Step 3: Query scholarships that match qualifications
    $this->db->where('application_end_date >=', date('Y-m-d'));
     // Step 4: Apply additional filter based on the selected scholarship type
    $this->db->where('scholarship_type', $selectedType);
    $this->db->order_by('scholarship_added_date', 'DESC');

    // Fetch all scholarships
    $scholarships = $this->db->get('scholarships')->result();

    // Initialize an array to store filtered scholarships
    $filteredScholarships = array();

    // Loop through all scholarships
    foreach ($scholarships as $scholarship) {
        $courses = json_decode($scholarship->courses);

        // Check if $courses is an array before using in_array()
        if (is_array($courses) && (in_array("All", $courses) || count(array_intersect($studentQualifications, $courses)) > 0)) {
            $filteredScholarships[] = $scholarship;
        }
    }

    // Return the filtered scholarships
    return $filteredScholarships;
}

/* START Updated code on 10 Jan 24 By Varun */


/* START Updated code on 9th Oct 23 By Varun */

public function get_student_by_email($email) {
        // Assuming 'student_registration' is your table name
        $query = $this->db->get_where('student_registration', array('registered_email' => $email));
        return $query->row_array();
    }


    public function update_paid_status($email) {
        // Assuming 'student_registration' is your table name
        $this->db->where('registered_email', $email);
        $this->db->update('student_registration', array('paid_status' => 1));
    }



/* END Updated code on 9th Oct 23 By Varun */


 public function get_scholarship_name($scholarship_id) {
        $this->db->where('scholarship_id', $scholarship_id);
        $query = $this->db->get('scholarships');
        $result = $query->row();
        return $result->scholarship_name;
    }

/* updated on 18 Nov 23 
public function update_payment_log($username) {
    // Assuming 'payment_log' is your table name for payment logs
    $this->db->where('student_username', $username);
    $this->db->update('payment_log', array('approved_status' => 1, 'source' => 'razorpay'));
}
 updated on 18 Nov 23 */

 public function update_payment_log($username) {
    $this->db->where('student_username', $username);
    $query = $this->db->get('payment_log');


    if ($query->num_rows() == 0) {
        // If the record does not exist, insert a new record
       $ipAddress=$this->Student_model->returnClientIPAddress();
        $data = array(
            'student_username' => $username,
            'action' => 'Paid',
            'date_time' => date('Y-m-d H:i:s'),
            'approved_status' => '1',
            'source' => 'razorpay',
            'ip'=>$ipAddress
        );
        $this->db->insert('payment_log', $data);
    } else {
        // If the record exists, update the existing record
        $this->db->where('student_username', $username);
        $this->db->update('payment_log', array('approved_status' => 1, 'source' => 'razorpay'));
    }
}






 public function payment_log($student_username, $action) {
    $ipAddress=$this->Student_model->returnClientIPAddress();
        $data = array(
            'student_username' => $student_username,
            'action' => $action,
            'date_time' => date('Y-m-d H:i:s'),
            'ip'=>$ipAddress
        );
        $this->db->insert('payment_log', $data);
    }



public function getPromoCode($studentUsername) {
        $query = $this->db->get_where('student_registration', array('student_username ' => $studentUsername));


        if ($query->num_rows() > 0) {
            $row = $query->row();
            return $row->promo_code;
        }


        return null; // Return null if no promo code is found
    }




public function affilitedcount($promoCode) {
    // Assuming you have a table called 'scholarship_log' with 'applied_status' column
    $this->db->where('affiliate_code', $promoCode);
    $count = $this->db->count_all_results('student_registration');
    return $count;
}
     /*=====================added start to add the internship on 21 DEC By varun ================================*/

public function searchEducationBasedforinernship($types) {
    $types = array_map(function ($type) {
        return str_replace('%20', ' ', $type);
    }, $types);

    $this->db->where_in('scholarship_type', $types);
    $this->db->where('application_end_date >=', date('Y-m-d'));
    $this->db->where('web_status', 1);
    $this->db->order_by('scholarship_added_date', 'DESC');

    $query = $this->db->get('scholarships')->result();

    return $query;
}
     /*=====================added end to add the internship on 21 DEC By varun ================================*/





public function getmatchedScholarshipsoncourceandqualification()
{
   // $studentUsername = 'QnQS1Bk9UH38';



$studentUsername = $this->session->userdata('student_username');
$selectedType = 'Scholarship';

    // Step 1: Fetch student qualifications
    $this->db->select('qualification, current_class_or_degree, student_studying_state');
    $this->db->where('student_username', $studentUsername);
    $qualificationsQuery = $this->db->get('student_academic_details');


    // Step 2: Extract student qualifications, current_class_or_degree, and student_studying_state
    $studentQualifications = array();
    $studentCurrentClassOrDegree = '';
    $studentStudyingState = '';


    foreach ($qualificationsQuery->result() as $row) {
        $studentQualifications[] = $row->qualification;
        $studentCurrentClassOrDegree = $row->current_class_or_degree;
        $studentStudyingState = $row->student_studying_state;
    }


    // Step 3: Query scholarships that match qualifications, current_class_or_degree, student_studying_state, and domicile
    $this->db->where('application_end_date >=', date('Y-m-d'));
    $this->db->where('scholarship_type', $selectedType);
    $this->db->order_by('scholarship_added_date', 'DESC');


    // Fetch all scholarships
    $scholarships = $this->db->get('scholarships')->result();


    // Step 4: Fetch scholarship IDs where the student has applied from scholarship_logs
    $appliedScholarshipIds = array();
    $this->db->select('scholarship_id');
    $this->db->where('student_username', $studentUsername);
    $this->db->where('apply_action', 'applied');
    $appliedScholarshipsQuery = $this->db->get('scholarship_logs');
    foreach ($appliedScholarshipsQuery->result() as $row) {
        $appliedScholarshipIds[] = $row->scholarship_id;
    }


    // Initialize an array to store filtered scholarships
    $filteredScholarships = array();


    // Loop through all scholarships
    foreach ($scholarships as $scholarship) {
        $scholarshipId = $scholarship->scholarship_id;


        // Check if the student has applied for this scholarship
        if (!in_array($scholarshipId, $appliedScholarshipIds)) {
            $courses = ($scholarship->courses !== null) ? json_decode($scholarship->courses) : [];
            $scholarshipCurrentClassOrDegree = ($scholarship->current_class_or_degree !== null) ? json_decode($scholarship->current_class_or_degree) : [];
            $scholarshipDomicile = ($scholarship->domicile !== null) ? json_decode($scholarship->domicile) : []; // Assuming domicile is in JSON format


            // Check if $courses is an array before using in_array()
            // If $scholarshipCurrentClassOrDegree is not null, consider it in the condition
            if (
                is_array($courses) &&
                (in_array("All", $courses) || count(array_intersect($studentQualifications, $courses)) > 0) &&
                (
                    empty($studentCurrentClassOrDegree) ||
                    (
                        empty($scholarshipCurrentClassOrDegree) ||
                        (is_array($scholarshipCurrentClassOrDegree) &&
                        (in_array("All", $scholarshipCurrentClassOrDegree) ||
                        in_array($studentCurrentClassOrDegree, $scholarshipCurrentClassOrDegree)))
                    )
                ) &&
                (
                    empty($studentStudyingState) || // Exclude state from comparison if it's empty
                    empty($scholarshipDomicile) ||
                    (in_array("All", $scholarshipDomicile) || count(array_intersect($scholarshipDomicile, [$studentStudyingState])) > 0)
                )
            ) {
                $filteredScholarships[] = $scholarship;
            }
        }
    }


    // Return the filtered scholarships
    return $filteredScholarships;
}

public function getmatchedScholarshipsontypecourceandstate($selectedType)
{
    /*$studentUsername = 'QnQS1Bk9UH38';*/
    $studentUsername = $this->session->userdata('student_username');


    // Step 1: Fetch student qualifications
    $this->db->select('qualification, current_class_or_degree, student_studying_state');
    $this->db->where('student_username', $studentUsername);
    $qualificationsQuery = $this->db->get('student_academic_details');


    // Step 2: Extract student qualifications, current_class_or_degree, and student_studying_state
    $studentQualifications = array();
    $studentCurrentClassOrDegree = '';
    $studentStudyingState = '';


    foreach ($qualificationsQuery->result() as $row) {
        $studentQualifications[] = $row->qualification;
        $studentCurrentClassOrDegree = $row->current_class_or_degree;
        $studentStudyingState = $row->student_studying_state;
    }


    // Step 3: Query scholarships that match qualifications, current_class_or_degree, student_studying_state, and domicile
    $this->db->where('application_end_date >=', date('Y-m-d'));
       $this->db->where('scholarship_type', $selectedType);
    $this->db->order_by('scholarship_added_date', 'DESC');


    // Fetch all scholarships
    $scholarships = $this->db->get('scholarships')->result();


    // Step 4: Fetch scholarship IDs where the student has applied from scholarship_logs
    $appliedScholarshipIds = array();
    $this->db->select('scholarship_id');
    $this->db->where('student_username', $studentUsername);
    $this->db->where('apply_action', 'applied');
    $appliedScholarshipsQuery = $this->db->get('scholarship_logs');
    foreach ($appliedScholarshipsQuery->result() as $row) {
        $appliedScholarshipIds[] = $row->scholarship_id;
    }


    // Initialize an array to store filtered scholarships
    $filteredScholarships = array();


    // Loop through all scholarships
    foreach ($scholarships as $scholarship) {
        $scholarshipId = $scholarship->scholarship_id;


        // Check if the student has applied for this scholarship
        if (!in_array($scholarshipId, $appliedScholarshipIds)) {
            $courses = ($scholarship->courses !== null) ? json_decode($scholarship->courses) : [];
            $scholarshipCurrentClassOrDegree = ($scholarship->current_class_or_degree !== null) ? json_decode($scholarship->current_class_or_degree) : [];
            $scholarshipDomicile = ($scholarship->domicile !== null) ? json_decode($scholarship->domicile) : []; // Assuming domicile is in JSON format


            // Check if $courses is an array before using in_array()
            // If $scholarshipCurrentClassOrDegree is not null, consider it in the condition
            if (
                is_array($courses) &&
                (in_array("All", $courses) || count(array_intersect($studentQualifications, $courses)) > 0) &&
                (
                    empty($studentCurrentClassOrDegree) ||
                    (
                        empty($scholarshipCurrentClassOrDegree) ||
                        (is_array($scholarshipCurrentClassOrDegree) &&
                        (in_array("All", $scholarshipCurrentClassOrDegree) ||
                        in_array($studentCurrentClassOrDegree, $scholarshipCurrentClassOrDegree)))
                    )
                ) &&
                (
                    empty($studentStudyingState) || // Exclude state from comparison if it's empty
                    empty($scholarshipDomicile) ||
                    (in_array("All", $scholarshipDomicile) || count(array_intersect($scholarshipDomicile, [$studentStudyingState])) > 0)
                )
            ) {
                $filteredScholarships[] = $scholarship;
            }
        }
    }


    // Return the filtered scholarships
    return $filteredScholarships;
}

public function getAppliedScholarships($studentUsername)
    {
        $this->db->select('scholarship_id');
        $this->db->where('student_username', $studentUsername);
        $this->db->where('apply_action', 'applied');


        $this->db->order_by('date_and_time', 'desc');
        $appliedScholarshipsQuery = $this->db->get('scholarship_logs');


        $appliedScholarshipIds = array();
        foreach ($appliedScholarshipsQuery->result() as $row) {
            $appliedScholarshipIds[] = $row->scholarship_id;
        }


        // Fetch details of applied scholarships
        $appliedScholarships = array();
        if (!empty($appliedScholarshipIds)) {
            $this->db->where_in('scholarship_id', $appliedScholarshipIds);
            $this->db->where('scholarship_type', 'Scholarship');
            /*$this->db->where('scholarship_type', 'Scholarship');*/
      
            $appliedScholarships = $this->db->get('scholarships')->result();
        }


        return $appliedScholarships;
    }
    public function filterScholarshipsontypeapplied($studentUsername,$type)
    {
        $this->db->select('scholarship_id');
        $this->db->where('student_username', $studentUsername);
        $this->db->where('apply_action', 'applied');
        $appliedScholarshipsQuery = $this->db->get('scholarship_logs');


        $appliedScholarshipIds = array();
        foreach ($appliedScholarshipsQuery->result() as $row) {
            $appliedScholarshipIds[] = $row->scholarship_id;
        }


        // Fetch details of applied scholarships
        $appliedScholarships = array();
        if (!empty($appliedScholarshipIds)) {
            $this->db->where_in('scholarship_id', $appliedScholarshipIds);
            $this->db->where('scholarship_type', $type);
            $appliedScholarships = $this->db->get('scholarships')->result();
        }


        return $appliedScholarships;
    }





public function countMatchingScholarshipsupdated($studentUsername) {
    // Step 1: Fetch student qualifications
    $this->db->select('qualification, current_class_or_degree, student_studying_state');
    $this->db->where('student_username', $studentUsername);
    $qualificationsQuery = $this->db->get('student_academic_details');


    // Step 2: Extract student qualifications, current_class_or_degree, and student_studying_state
    $studentQualifications = array();
    $studentCurrentClassOrDegree = '';
    $studentStudyingState = '';


    foreach ($qualificationsQuery->result() as $row) {
        $studentQualifications[] = $row->qualification;
        $studentCurrentClassOrDegree = $row->current_class_or_degree;
        $studentStudyingState = $row->student_studying_state;
    }


    // Step 3: Query scholarships that match qualifications, current_class_or_degree, student_studying_state, and domicile
    $this->db->where('application_end_date >=', date('Y-m-d'));
           $this->db->where('scholarship_type', 'Scholarship');




    // Fetch all scholarships
    $scholarships = $this->db->get('scholarships')->result();


    // Initialize a count variable
    $matchingCount = 0;


    // Loop through all scholarships
    foreach ($scholarships as $scholarship) {
        $courses = ($scholarship->courses !== null) ? json_decode($scholarship->courses) : [];
        $scholarshipCurrentClassOrDegree = ($scholarship->current_class_or_degree !== null) ? json_decode($scholarship->current_class_or_degree) : [];
        $scholarshipDomicile = ($scholarship->domicile !== null) ? json_decode($scholarship->domicile) : []; // Assuming domicile is in JSON format


        // Check if $courses is an array before using in_array()
        // If $scholarshipCurrentClassOrDegree is not null, consider it in the condition
        if (
            is_array($courses) &&
            (in_array("All", $courses) || count(array_intersect($studentQualifications, $courses)) > 0) &&
            (
                empty($studentCurrentClassOrDegree) ||
                (
                    empty($scholarshipCurrentClassOrDegree) ||
                    (is_array($scholarshipCurrentClassOrDegree) &&
                    (in_array("All", $scholarshipCurrentClassOrDegree) ||
                    in_array($studentCurrentClassOrDegree, $scholarshipCurrentClassOrDegree)))
                )
            ) &&
            (
                empty($studentStudyingState) || // Exclude state from comparison if it's empty
                empty($scholarshipDomicile) ||
                (in_array("All", $scholarshipDomicile) || count(array_intersect($scholarshipDomicile, [$studentStudyingState])) > 0)
            )
        ) {
            $matchingCount++;
        }
    }


    return $matchingCount;
}


public function sumMatchingScholarshipsWorthUpdated($studentUsername) {
    // Initialize the sum variable
    $matchingScholarshipsWorth = 0;


    // Query matching scholarships based on student qualifications and application end date
    $this->db->select('qualification, current_class_or_degree, student_studying_state');
    $this->db->where('student_username', $studentUsername);
    $qualificationsQuery = $this->db->get('student_academic_details');


    // Extract student qualifications, current_class_or_degree, and student_studying_state
    $studentQualifications = array();
    $studentCurrentClassOrDegree = '';
    $studentStudyingState = '';


    foreach ($qualificationsQuery->result() as $row) {
        $studentQualifications[] = $row->qualification;
        $studentCurrentClassOrDegree = $row->current_class_or_degree;
        $studentStudyingState = $row->student_studying_state;
    }


    // Fetch scholarships that meet the application end date condition
    $this->db->where('application_end_date >=', date('Y-m-d'));
    $this->db->where('scholarship_type', 'Scholarship'); // Adjusted based on the count function


    // Fetch all scholarships
    $scholarships = $this->db->get('scholarships')->result();


    // Loop through scholarships to calculate the sum
    foreach ($scholarships as $scholarship) {
        $courses = ($scholarship->courses !== null) ? json_decode($scholarship->courses) : [];
        $scholarshipCurrentClassOrDegree = ($scholarship->current_class_or_degree !== null) ? json_decode($scholarship->current_class_or_degree) : [];
        $scholarshipDomicile = ($scholarship->domicile !== null) ? json_decode($scholarship->domicile) : []; // Assuming domicile is in JSON format


        // Check if $courses is an array before using in_array()
        // If $scholarshipCurrentClassOrDegree is not null, consider it in the condition
        if (
            is_array($courses) &&
            (in_array("All", $courses) || count(array_intersect($studentQualifications, $courses)) > 0) &&
            (
                empty($studentCurrentClassOrDegree) ||
                (
                    empty($scholarshipCurrentClassOrDegree) ||
                    (is_array($scholarshipCurrentClassOrDegree) &&
                    (in_array("All", $scholarshipCurrentClassOrDegree) ||
                    in_array($studentCurrentClassOrDegree, $scholarshipCurrentClassOrDegree)))
                )
            ) &&
            (
                empty($studentStudyingState) || // Exclude state from comparison if it's empty
                empty($scholarshipDomicile) ||
                (in_array("All", $scholarshipDomicile) || count(array_intersect($scholarshipDomicile, [$studentStudyingState])) > 0)
            )
        ) {
            $matchingScholarshipsWorth += $scholarship->scholarship_worth;
        }
    }


    return $matchingScholarshipsWorth;
}
public function sumAppliedScholarshipsWorthupdated($studentUsername) {
    // Get the scholarships that have been applied by the student
    $this->db->select('scholarship_id');
    $this->db->where('student_username', $studentUsername);
    $this->db->where('apply_action', 'applied');
    $appliedScholarships = $this->db->get('scholarship_logs')->result();


    $totalWorth = 0;


    foreach ($appliedScholarships as $appliedScholarship) {
        $this->db->select('scholarship_worth');
        $this->db->where('scholarship_id', $appliedScholarship->scholarship_id);
        $this->db->where('scholarship_type', 'Scholarship');
        $worth = $this->db->get('scholarships')->row()->scholarship_worth;


        $totalWorth += $worth;
    }


    return $totalWorth;
}
public function countAppliedScholarshipsWithType($studentUsername) {
    // Fetch scholarship_ids from scholarship_logs where the student has applied
    $this->db->select('scholarship_id');
    $this->db->where('student_username', $studentUsername);
    $this->db->where('apply_action', 'applied');
    $appliedScholarshipsQuery = $this->db->get('scholarship_logs');
    $appliedScholarshipIds = $appliedScholarshipsQuery->result_array();


    // Initialize an array to store scholarship types
    $scholarshipTypes = array();


    // Loop through applied scholarships to fetch scholarship types from the scholarships table
    foreach ($appliedScholarshipIds as $appliedScholarshipId) {
        $this->db->select('scholarship_type');
        $this->db->where('scholarship_id', $appliedScholarshipId['scholarship_id']);
        $scholarshipTypeQuery = $this->db->get('scholarships');
        $scholarshipType = $scholarshipTypeQuery->row('scholarship_type');


        // Store scholarship type in the array
        if ($scholarshipType) {
            $scholarshipTypes[] = $scholarshipType;
        }
    }


    // Count scholarships with type 'scholarship'
    $count = array_count_values($scholarshipTypes);
    $scholarshipCount = isset($count['Scholarship']) ? $count['Scholarship'] : 0;


    return $scholarshipCount;
}




    public function countpendingScholarshipsupdated($studentUsername)
{
    
    // Step 1: Fetch student qualifications
    $this->db->select('qualification, current_class_or_degree, student_studying_state');
    $this->db->where('student_username', $studentUsername);
    $qualificationsQuery = $this->db->get('student_academic_details');


    // Step 2: Extract student qualifications, current_class_or_degree, and student_studying_state
    $studentQualifications = array();
    $studentCurrentClassOrDegree = '';
    $studentStudyingState = '';


    foreach ($qualificationsQuery->result() as $row) {
        $studentQualifications[] = $row->qualification;
        $studentCurrentClassOrDegree = $row->current_class_or_degree;
        $studentStudyingState = $row->student_studying_state;
    }


    // Step 3: Query scholarships that match qualifications, current_class_or_degree, student_studying_state, and domicile
    $this->db->where('application_end_date >=', date('Y-m-d'));
    $this->db->where('scholarship_type', 'Scholarship');
    $this->db->order_by('scholarship_added_date', 'DESC');


    // Fetch all scholarships
    $scholarships = $this->db->get('scholarships')->result();


    // Step 4: Fetch scholarship IDs where the student has applied from scholarship_logs
    $appliedScholarshipIds = array();
    $this->db->select('scholarship_id');
    $this->db->where('student_username', $studentUsername);
    $this->db->where('apply_action', 'applied');
    $appliedScholarshipsQuery = $this->db->get('scholarship_logs');
    foreach ($appliedScholarshipsQuery->result() as $row) {
        $appliedScholarshipIds[] = $row->scholarship_id;
    }


    // Initialize a counter for matching scholarships
    $matchingScholarshipsCount = 0;


    // Loop through all scholarships
    foreach ($scholarships as $scholarship) {
        $scholarshipId = $scholarship->scholarship_id;


        // Check if the student has applied for this scholarship
        if (!in_array($scholarshipId, $appliedScholarshipIds)) {
            $courses = ($scholarship->courses !== null) ? json_decode($scholarship->courses) : [];
            $scholarshipCurrentClassOrDegree = ($scholarship->current_class_or_degree !== null) ? json_decode($scholarship->current_class_or_degree) : [];
            $scholarshipDomicile = ($scholarship->domicile !== null) ? json_decode($scholarship->domicile) : []; // Assuming domicile is in JSON format


            // Check if $courses is an array before using in_array()
            // If $scholarshipCurrentClassOrDegree is not null, consider it in the condition
            if (
                is_array($courses) &&
                (in_array("All", $courses) || count(array_intersect($studentQualifications, $courses)) > 0) &&
                (
                    empty($studentCurrentClassOrDegree) ||
                    (
                        empty($scholarshipCurrentClassOrDegree) ||
                        (is_array($scholarshipCurrentClassOrDegree) &&
                        (in_array("All", $scholarshipCurrentClassOrDegree) ||
                        in_array($studentCurrentClassOrDegree, $scholarshipCurrentClassOrDegree)))
                    )
                ) &&
                (
                    empty($studentStudyingState) || // Exclude state from comparison if it's empty
                    empty($scholarshipDomicile) ||
                    (in_array("All", $scholarshipDomicile) || count(array_intersect($scholarshipDomicile, [$studentStudyingState])) > 0)
                )
            ) {
                $matchingScholarshipsCount++;
            }
        }
    }


    // Return the count of matching scholarships
    return $matchingScholarshipsCount;
}
public function worthofpendingScholarshipsupdated($studentUsername)
{


    // Initialize the sum variable
    $matchingScholarshipsWorth = 0;


    // Query scholarships that match qualifications, current_class_or_degree, student_studying_state, and domicile
    $this->db->select('qualification, current_class_or_degree, student_studying_state');
    $this->db->where('student_username', $studentUsername);
    $qualificationsQuery = $this->db->get('student_academic_details');


    // Extract student qualifications, current_class_or_degree, and student_studying_state
    $studentQualifications = array();
    $studentCurrentClassOrDegree = '';
    $studentStudyingState = '';


    foreach ($qualificationsQuery->result() as $row) {
        $studentQualifications[] = $row->qualification;
        $studentCurrentClassOrDegree = $row->current_class_or_degree;
        $studentStudyingState = $row->student_studying_state;
    }


    // Query scholarships that meet the application end date condition
    $this->db->where('application_end_date >=', date('Y-m-d'));
    $this->db->where('scholarship_type', 'Scholarship'); // Adjusted based on the count function
    $this->db->order_by('scholarship_added_date', 'DESC');


    // Fetch all scholarships
    $scholarships = $this->db->get('scholarships')->result();


    // Fetch scholarship IDs where the student has applied from scholarship_logs
    $appliedScholarshipIds = array();
    $this->db->select('scholarship_id');
    $this->db->where('student_username', $studentUsername);
    $this->db->where('apply_action', 'applied');
    $appliedScholarshipsQuery = $this->db->get('scholarship_logs');
    foreach ($appliedScholarshipsQuery->result() as $row) {
        $appliedScholarshipIds[] = $row->scholarship_id;
    }


    // Loop through scholarships to calculate the sum
    foreach ($scholarships as $scholarship) {
        $scholarshipId = $scholarship->scholarship_id;


        // Check if the student has applied for this scholarship
        if (!in_array($scholarshipId, $appliedScholarshipIds)) {
            $courses = ($scholarship->courses !== null) ? json_decode($scholarship->courses) : [];
            $scholarshipCurrentClassOrDegree = ($scholarship->current_class_or_degree !== null) ? json_decode($scholarship->current_class_or_degree) : [];
            $scholarshipDomicile = ($scholarship->domicile !== null) ? json_decode($scholarship->domicile) : []; // Assuming domicile is in JSON format


            // Check if $courses is an array before using in_array()
            // If $scholarshipCurrentClassOrDegree is not null, consider it in the condition
            if (
                is_array($courses) &&
                (in_array("All", $courses) || count(array_intersect($studentQualifications, $courses)) > 0) &&
                (
                    empty($studentCurrentClassOrDegree) ||
                    (
                        empty($scholarshipCurrentClassOrDegree) ||
                        (is_array($scholarshipCurrentClassOrDegree) &&
                        (in_array("All", $scholarshipCurrentClassOrDegree) ||
                        in_array($studentCurrentClassOrDegree, $scholarshipCurrentClassOrDegree)))
                    )
                ) &&
                (
                    empty($studentStudyingState) || // Exclude state from comparison if it's empty
                    empty($scholarshipDomicile) ||
                    (in_array("All", $scholarshipDomicile) || count(array_intersect($scholarshipDomicile, [$studentStudyingState])) > 0)
                )
            ) {
                $matchingScholarshipsWorth += $scholarship->scholarship_worth;
            }
        }
    }


    // Return the sum of matching scholarships' worth
    return $matchingScholarshipsWorth;
}




}?>