<?php

/**
 * Widget.php
 *
 * -Description-
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <https://www.gnu.org/licenses/>.
 *
 * @link       https://www.librenms.org
 *
 * @copyright  2020 Thomas Berberich
 * @author     Thomas Berberich <sourcehhdoctor@gmail.com>
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Poller extends Model
{
    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $fillable = ['poller_name'];

    // ---- Scopes ----

    public function scopeIsInactive(Builder $query): Builder
    {
        $default = (int) \App\Facades\LibrenmsConfig::get('rrd.step');

        return $query->where('last_polled', '<', \DB::raw("DATE_SUB(NOW(),INTERVAL $default SECOND)"));
    }

    public function scopeIsActive(Builder $query): Builder
    {
        $default = (int) \App\Facades\LibrenmsConfig::get('rrd.step');

        return $query->where('last_polled', '>=', \DB::raw("DATE_SUB(NOW(),INTERVAL $default SECOND)"));
    }
}
