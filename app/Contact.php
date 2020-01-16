<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable=['name', 'email', 'phone', 'language', 'type', 'creator_id'];
    public function getNameLinkAttribute()
    {
        $title = __('app.show_detail_title', [
            'name' => $this->name
        ]);
        $link = '<a href="'.route('contacts.edit', $this).'"';
        $link .= ' title="'.$title.'">';
        $link .= $this->name;
        $link .= '</a>';

        return $link;
    }
    public function getAdminLinkAttribute()
    {
        $title = __('app.show_detail_title', [
            'name' => $this->name
        ]);
        $link = '<a href="'.route('admin.contacts.edit', $this).'"';
        $link .= ' title="'.$title.'">';
        $link .= $this->name;
        $link .= '</a>';

        return $link;
    }
    public function getLanguageNameAttribute()
    {
        $ln_type=$this->language;


        return $ln_type == 'en'? 'Английский':'Русский';
    }
    public function getTypeNameAttribute()
    {
        $type=$this->type;


        return $type == 0? 'Персональный':'Отдел/служба';
    }
}
