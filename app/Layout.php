<?php

namespace App;

use Illuminate\Database\Eloquent\Model;



class Layout extends Model
{
    public function CardInstances()
    {
        return $this->hasMany(CardInstances::class);
    }

    public function createBlankLayout($layoutName, $layoutHeight, $layoutWidth, $cardParams, $layoutDescription)
    {
        $thisNewLayout = new Layout;
        $thisNewLayout->menu_label = $layoutName;
        $thisNewLayout->height = $layoutHeight;
        $thisNewLayout->width = $layoutWidth;
        $thisNewLayout->description = $layoutDescription;
        $thisNewLayout->save();
        $totalNumberOfCells = $layoutHeight * $layoutWidth;
        $row = 1;
        $column = 1;
        for ($x = 0; $x < $totalNumberOfCells; $x++) {
//            $blankLayoutStyle = "grid-area:" . $row . " / " . $column . " / " . $row . " / " . ($column + 1) . ";" . $blankLayoutBackground;
//            $blankLayoutStyle = $blankLayoutBackground;
//            $fontColorCss = "color: blue;";
//            $newParams = [['key'=>'style', 'value'=>$blankLayoutStyle]];
//            $newParams = [['style',$blankLayoutStyle],[]]
            $thisCardInstance = new CardInstances;
            $thisCardInstance->createCardInstance($thisNewLayout->id, $cardParams, $row, $column, 1,1, 'simpleCard');
//           $fontColorCss = "color: blue;";
//            $newParams = [['key'=>'style', 'value'=>$fontColorCss]];
//            $thisCardInstance = new CardInstances;
//            $thisCardInstance->createCardInstance($thisNewLayout->id, $cardParams, $row, $column, 1,1);

            $column++;
            if($column>$layoutWidth){
                $column=1;
                $row++;
            }
        }
        return $thisNewLayout->id;
    }
}
