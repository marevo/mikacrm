<?php
//можем здесь писать если просто вывод или пока что при подключении будет autoload.php в head.php
require '../../autoload.php';
////       echo get_called_class();
////        echo Нужно отметить, что для большего удобства в PHP кроме слова «static» есть еще специальная функция get_called_class(), которая сообщит вам — в контексте какого класса в данный момент работает ваш код.

                //                получим из таблицы всех поставщиков и покажем через вызов быстрого показа в трэйте FastViewTable.php
                if($_GET["timeframe"]=="day")
				{
                    $data= \App\Models\Reports::getPreviousDay();
                    //$output="[{'Дата','Чистая прибыль','Доход'},{'".$data[0]->date."','".$data[0]->pure."','".$data[0]->income."'}]";
					$output=$data[0]->date.",".$data[0]->pure.",".$data[0]->income.";";
                    echo $output;			
				}
				if($_GET["timeframe"]=="week")
				{
                    $data= \App\Models\Reports::getPreviousWeek();
                    //$output="[{'Дата','Чистая прибыль','Доход'},{'".$data[0]->date."','".$data[0]->pure."','".$data[0]->income."'}]";
					$output="";
					foreach($data as $row)
					{
					    $output.=$row->date.",".$row->pure.",".$row->income.";";
					}
                    echo $output;			
				}
				if($_GET["timeframe"]=="month")
				{
                    $data= \App\Models\Reports::getPreviousMonth();
                    //$output="[{'Дата','Чистая прибыль','Доход'},{'".$data[0]->date."','".$data[0]->pure."','".$data[0]->income."'}]";
					$output="";
					foreach($data as $row)
					{
					    $output.=$row->date.",".$row->pure.",".$row->income.";";
					}
                    echo $output;			
				}
				if($_GET["timeframe"]=="year")
				{
                    $data= \App\Models\Reports::getPreviousYear();
                    //$output="[{'Дата','Чистая прибыль','Доход'},{'".$data[0]->date."','".$data[0]->pure."','".$data[0]->income."'}]";
					$output="";
					foreach($data as $row)
					{
					    $output.=$row->date.",".$row->pure.",".$row->income.";";
					}
                    echo $output;			
				}
				if($_GET["timeframe"]=="custom")
				{
                    $data= \App\Models\Reports::getCustomRange($_GET["start"],$_GET["end"]);
                    //$output="[{'Дата','Чистая прибыль','Доход'},{'".$data[0]->date."','".$data[0]->pure."','".$data[0]->income."'}]";
					$output="";
					foreach($data as $row)
					{
					    $output.=$row->date.",".$row->pure.",".$row->income.";";
					}
                    echo $output;			
				}
                ?>