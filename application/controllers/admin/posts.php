<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Posts extends Admin_Controller
{
	function __construct()
	{
		parent::__construct();

		if (!($this->tank_auth->is_allowed()))
			redirect('admin');

		$this->load->model('post');
		
		// title on top
		$this->viewdata['controller_title'] = '<a href="'.site_url("admin/posts").'">' . _("Posts") . '</a>';;
	}


	function index()
	{
		return $this->reports();
	}


	function reports($page = 1)
	{
		$this->viewdata["function_title"] = _('Reports');
		
		
		$data['posts'] = $this->post->get_reports($page);

		$this->viewdata["main_content_view"] = $this->load->view("admin/reports/manage.php", $data, TRUE);
		$this->load->view("admin/default.php", $this->viewdata);
	}


	function action($type = 'remove', $report_id = 0, $remove = NULL)
	{
		if (!$this->input->is_ajax_request())
		{
			$this->output->set_output(_('Access to reports outside the administrative panel is denied.'));
			log_message('error', 'Controller: reports.php/action: access denied');
			return FALSE;
		}

		if (isset($_SERVER['HTTP_REFERER']))
		{
			$redirect = $_SERVER['HTTP_REFERER'];
		}
		else
		{
			$redirect = site_url('admin/posts/reports');
		}


		switch ($type)
		{
			case('ban'):

				$report = new Report();
				$result = $report->process_report(
					$report_id,
					array(
						'action' => 'ban',
						'value' => array(
							'banned_reason' => $this->input->post('banned_reason'),
							'banned_start' => $this->input->post('banned_start'),
							'banned_end' => $this->input->post('banned_end')
						)
					)
				);
				if (isset($result['error']))
				{
					flash_notice('error', $result['message']);
					$this->output->set_output(json_encode(array('href' => $redirect)));
					return FALSE;
				}
				flash_notice('notice', $result['message']);
				$this->output->set_output(json_encode(array('href' => $redirect)));

				break;

			case('delete'):

				$report = new Report();
				$result = $report->process_report(
					$report_id,
					array(
						'action' => 'delete',
						'value' => array(
							'delete' => $remove
						)
					)
				);
				if (isset($result['error']))
				{
					flash_notice('error', $result['message']);
					$this->output->set_output(json_encode(array('href' => $redirect)));
					return FALSE;
				}
				flash_notice('notice', $result['message']);
				$this->output->set_output(json_encode(array('href' => $redirect)));

				break;

			case('md5'):

				$report = new Report();
				$result = $report->process_report(
					$report_id,
					array(
						'action' => 'md5'
					)
				);
				if (isset($result['error']))
				{
					flash_notice('error', $result['message']);
					$this->output->set_output(json_encode(array('href' => $redirect)));
					return FALSE;
				}
				flash_notice('notice', $result['message']);
				$this->output->set_output(json_encode(array('href' => $redirect)));

				break;

			case('remove'):

				$report = new Report($report_id);
				if (!$report->remove_report_db())
				{
					flash_notice('error', _('Failed to remove the report from the database.'));
					log_message('error', 'Controller: reports.php/remove: failed to remove the report');
					$this->output->set_output(json_encode(array('href' => $redirect)));
					return FALSE;
				}
				flash_notice('notice', _('The report has been removed from the database.'));
				$this->output->set_output(json_encode(array('href' => $redirect)));

				break;

			case('spam'):

				$report = new Report();
				$result = $report->process_report(
					$report_id,
					array(
						'action' => 'spam'
					)
				);
				if (isset($result['error']))
				{
					flash_notice('error', $result['message']);
					$this->output->set_output(json_encode(array('href' => $redirect)));
					return FALSE;
				}
				flash_notice('notice', $result['message']);
				$this->output->set_output(json_encode(array('href' => $redirect)));

				break;
		}
	}


}