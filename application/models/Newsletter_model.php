<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Newsletter_model extends CI_Model
{
    //add to subscriber
    public function add_subscriber($email)
    {
        $data = array(
            'email' => $email
        );
        $data['created_at'] = date('Y-m-d H:i:s');
        return $this->db->insert('newsletters', $data);
    }

    //update subscriber token
    public function update_subscriber_token($email)
    {
        $subscriber = $this->get_subscriber($email);
        if (!empty($subscriber)) {
            if (empty($subscriber->token)) {
                $data = array(
                    'token' => generate_unique_id()
                );
                $this->db->where('email', $email);
                $this->db->update('newsletters', $data);
            }
        }
    }

    //get subscribers
    public function get_subscribers()
    {
        $query = $this->db->get('newsletters');
        return $query->result();
    }

    //get subscriber
    public function get_subscriber($email)
    {
        $this->db->where('email', $email);
        $query = $this->db->get('newsletters');
        return $query->row();
    }

    //get subscriber by id
    public function get_subscriber_by_id($id)
    {
        $id = sql_escape_number($id);
        $this->db->where('id', $id);
        $query = $this->db->get('newsletters');
        return $query->row();
    }

    //delete from subscribers
    public function delete_from_subscribers($id)
    {
        $id = sql_escape_number($id);
        $this->db->where('id', $id);
        return $this->db->delete('newsletters');
    }

    //get subscriber
    public function get_subscriber_by_token($token)
    {
        $this->db->where('token', $token);
        $query = $this->db->get('newsletters');
        return $query->row();
    }

    //unsubscribe email
    public function unsubscribe_email($email)
    {
        $this->db->where('email', $email);
        $this->db->delete('newsletters');
    }
}