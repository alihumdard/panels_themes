<?php

    function status_button($id = null, $val = null)
    {
        return '<label class="switch switch-3d switch-success mr-3">
                  <input type="checkbox" ref="'.$id.'" '.(($val == 0) ? 'value="0"' : 'value="1" checked="checked"').' class="switch-input status">
                  <span class="switch-label"></span>
                  <span class="switch-handle"></span>
                </label>';
    }
