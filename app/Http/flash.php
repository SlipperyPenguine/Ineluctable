<?php
/**
 * Created by PhpStorm.
 * User: John
 * Date: 07/08/2015
 * Time: 23:36
 */

namespace ineluctable\Http;


class flash
{
    private function create($title, $message, $level)
    {
        session()->flash('flash_message',[
            'title' => $title,
            'message' => $message,
            'level' => $level
        ] );
    }

    public function message($title, $message)
    {
        return $this->create($title, $message, 'info');
    }

    public function success($title, $message)
    {
        return $this->create($title, $message, 'success');
    }

    public function warning($title, $message)
    {
        return $this->create($title, $message, 'warning');
    }

    public function error($title, $message)
    {
        return $this->create($title, $message, 'error');
    }
}