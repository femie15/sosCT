<style type="text/css">
<!--
.style2 {color: #99000f}
.style3 {font-size: 18px}
-->
</style><?php



//CONNECT TO THE HOST AND THE DATABASE
$con = mysqli_connect("localhost","oyoedumi_school","","oes") or die("Connection problem.");
$sn = 0;
$dl = "";
$msg = "";
$studid = "";
$stid = "";
$ans = "";
$grade = "";
$remark = "";
$class_avg1="";
$result_count=0;
$subj = "";
$clss = "";
$tem = "";
$ses = "";
	

										//RESULT TABLE

									$sqls = "SELECT * FROM stud ";
									$querys = mysqli_query($con, $sqls);
									$counts = mysqli_num_rows($querys);

									if($counts > 0){								

										
														$dl = '
																('.$counts.') students Names are displayed.<br><hr><br><center>	
																	<form method="post" action="#">											
																	<table width="70%" border="3" cellspacing="1" cellpadding="2">
																	<tr bgcolor="#1921e2">
																	
																	</tr></center>
																	

																';
																		
																						
														while($rows = mysqli_fetch_array($querys)){
																							
		$qid = $rows['student_id'];
		$qid1 = $rows['student_id'];
		$q = $rows['name'];
		$a = $rows['address'];if($a ==""){ $a ="ketu";}
		$b = $rows['phone'];if($b ==""){ $b ="080";}
		$c = $rows['email'];if($c ==""){ $c ="email";}
		$d = $rows['password'];if($d ==""){ $d ="12345";}
		$e = $rows['home_town'];	if($e ==""){ $e ="ketu";}
																						
																				
																																										
																								
																								$sqlst = "SELECT * FROM stud WHERE student_id='$qid'";																																										
																							
																								$queryst = mysqli_query($con, $sqlst);
																								$countst = mysqli_num_rows($queryst);																								
																								$countt=0;
																									//$counts=$countst;

																								while($rowst = mysqli_fetch_array($queryst)){																					
																																	
																											$qid = $rowst['student_id'];
																											$q = $rowst['name'];
																											$a = $rowst['address'];if($a ==""){ $a ="ketu";}
																											$b = $rowst['phone'];if($b ==""){ $b ="080";}
																											$c = $rowst['email'];if($c ==""){ $c ="email";}
																											$d = $rowst['password'];if($d ==""){ $d ="12345";}
																											$e = $rowst['home_town'];	if($e ==""){ $e ="ketu";}
																																																	
																																																		
																									
																								}

																								
																										$sqlino= "INSERT INTO star (stdid,stdname,stdpassword,emailid,contactno,address,city,pincode) VALUES ('$qid','$q',ENCODE('".htmlspecialchars($d,ENT_QUOTES)."','oespass'),'$c','$b','$a','$e','12345')";
	
																										$queryino = mysqli_query($con, $sqlino);								
																						
																																											
																						
																				}
																			$dl .= '</table>';
																			$dl .=	'<br><button class="add_field_button" style="float:right; color:#0456ee; margin-right:30px;">Save Result</button>';
																			$dl .= '</form>';	
 
																					
																								
								} else{
										$msg= '<h3 style="float:center; color:red;">No Student in this class...Please Select Class</h3>';
									}		  
				

		
