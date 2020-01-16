<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Outlet extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'address_street', 'address_city', 'latitude', 'longitude', 'creator_id','location_id','AP_no','location_type', 'info_URL'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    public $appends = [
        'coordinate', 'map_popup_content'
    ];

    /**
     * Get outlet name_link attribute.
     *
     * @return string
     */
    public function getNameLinkAttribute()
    {
        $title = __('app.show_detail_title', [
            'name' => $this->name, 'type' => __('outlet.outlet'),
        ]);
        $link = '<a href="'.route('outlets.show', $this).'"';
        $link .= ' title="'.$title.'">';
        $link .= $this->name;
        $link .= '</a>';

        return $link;
    }

    public function getAdminLinkAttribute()
    {
        $title = __('app.show_detail_title', [
            'name' => $this->name, 'type' => __('outlet.outlet'),
        ]);
        $link = '<a href="'.route('admin.outlets.show', $this).'"';
        $link .= ' title="'.$title.'">';
        $link .= $this->name;
        $link .= '</a>';
        $adminLink = $link;
        return $adminLink;
    }

    /**
     * Outlet belongs to User model relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creator()
    {
        return $this->belongsTo(User::class);
    }



    /**
     * Get outlet coordinate attribute.
     *
     * @return string|null
     */
    public function getCoordinateAttribute()
    {
        if ($this->latitude && $this->longitude) {
            return $this->latitude.', '.$this->longitude;
        }
        else return '';
    }

    /**
     * Get outlet map_popup_content attribute.
     *
     * @return string
     */
    public function getMapPopupContentAttribute()
    {
        $mapPopupContent = '';
        $mapPopupContent .= '<div class="my-2"><strong>'.__('outlet.name').':</strong><br>'.$this->name_link.'</div>';
        $mapPopupContent .= '<div class="my-2"><strong>'.__('outlet.address').':</strong><br>'.$this->address_city.', '.$this->address_street.'</div>';

        return $mapPopupContent;
    }
    public function getMapAdminPopupContentAttribute()
    {
        $mapPopupContent = '';
        $mapPopupContent .= '<div class="my-2"><strong>'.__('outlet.name').':</strong><br>'.$this->admin_link.'</div>';
        $mapPopupContent .= '<div class="my-2"><strong>'.__('outlet.address').':</strong><br>'.$this->address_city.', '.$this->address_street.'</div>';
        $mapAdminPopupContent = $mapPopupContent;
        return $mapAdminPopupContent;
    }

    public function locType()
    {
        $venue ='';
        switch($this->location_type)
        {

            case '3,3':
                $venue = "Университет, колледж";
                break;
            case '2,8' :
                $venue = "Исследовательский институт";
                break;
            case '7,3' :
                $venue = "Общежитие";
        }

        return $venue;
    }


}
