<?php
/**
* @author: Shakti Singh
* @date: 20-02-2013
* @desc: Exam Model class : This class will handle all the database operations for Exam module
*/
class Exam extends Model 
{
	public $table = 'examination';
	
	public function __construct()
	{
		parent::__construct();
	}
	/**
	*	Get exam info 
	*/
	public function getExamInfo($candidate_id)
	{
		$sql = " SELECT test.id, test.test_name, test.time_duration, test.maximum_marks, count(tq.id) as total_questions
				FROM examination as exam 
				JOIN test ON exam.id = test.exam_id 
				JOIN exam_filter ef ON exam.id = ef.exam_id
				JOIN candidate c ON c.stream_id = ef.stream_id
				JOIN test_questions tq ON tq.test_id = test.id
		   
				WHERE (date_format(now(), '%Y-%m-%d %H:%i:%s') >= date_format(test_date, '%Y-%m-%d %H:%i:%s'))
				AND (date_format(now(), '%Y-%m-%d %H:%i:%s') <= date_format(test_date_end, '%Y-%m-%d %H:%i:%s'))
				AND (enable_test = 'Y')
				AND (test.id NOT IN (SELECT test_id FROM candidate_test_history WHERE candidate_id = c.id))
				AND (c.id NOT IN (SELECT candidate_id FROM exam_candidate_exclude WHERE exam_id = exam.id ))
				AND c.id =?
				GROUP BY test.id
				ORDER BY test.created_date desc limit 1";
		
		return $this->db->query($sql)->bind(1, $candidate_id)->fetch();
	}
	/**
	* Return info of question media as object for requested test
	*/
	public function getQuestionMedia($test_id)
	{
		$sql = "SELECT question_media FROM test WHERE id = ?" ;
		return $this->db->query($sql)->bind(1, $test_id)->fetchObject();
	}
	
	/**
	*	Return info of Paper as object for requested test 
	*/	
	public function getPaperInfo($test_id)
	{
		$sql = "SELECT * FROM test_paper WHERE test_id = ?" ;
		return $this->db->query($sql)->bind(1, $test_id)->fetchObject();
	}
	/**
	*	Return subjects in a Test
	*/
	public function getSubjects($id, $table)
	{
		$sql = "SELECT subject_id, subject_name, show_subject_diff_question 
				FROM {$table}_subject
				JOIN subject ON {$table}_subject.subject_id = subject.id WHERE {$table}_id = ?";
		return $this->db->query($sql)->bind(1, $id)->fetchAll();
	}
	/**
	*	Return custom questions
	*/
	public function getCustomQuestionQuery()
	{
		 
	}
}
