<?php

/*
 * LMS version 1.7-cvs
 *
 *  (C) Copyright 2001-2005 LMS Developers
 *
 *  Please, see the doc/AUTHORS for more information about authors!
 *
 *  This program is free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License Version 2 as
 *  published by the Free Software Foundation.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program; if not, write to the Free Software
 *  Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA 02111-1307,
 *  USA.
 *
 *  $Id$
 */
// Faktury w PDF, do u�ycia z formularzami FT-0100 (c) Polarnet
// w razie pyta� mailto:lexx@polarnet.org

function text_autosize($x,$y,$size,$text,$width) 
{
    global $pdf;
    while ($pdf->getTextWidth($size,$text)>$width) $size=$size-1;
    $pdf->addtext($x,$y,$size,$text);
}

function text_align_right($x,$y,$size,$text) 
{
    global $pdf;
    $pdf->addText($x-$pdf->getTextWidth($size,$text),$y,$size,$text);
    return($pdf->getFontHeight($size));
}

function text_align_left($x,$y,$size,$text) 
{
    global $pdf;
    $pdf->addText($x,$y,$size,$text);
    return($pdf->getFontHeight($size));
}

function text_wrap($x,$y,$width,$size,$text,$justify) 
{
    global $pdf;
    while ($text!='') {
	$text = $pdf->addTextWrap($x, $y, $width, $size,$text,$justify);
	$y = $y - $pdf->getFontHeight($size);
    }
    return($y);
}

function invoice_simple_form_fill($x,$y,$scale)  
{
    global $pdf,$invoice,$CONFIG;
    $finances = $CONFIG['finances'];
    $pdf->setlinestyle(1);

    $pdf->line(7*$scale+$x,724*$scale+$y,7*$scale+$x,694*$scale+$y);
    $pdf->line(7*$scale+$x,724*$scale+$y,37*$scale+$x,724*$scale+$y);
    $pdf->line(370*$scale+$x,724*$scale+$y,370*$scale+$x,694*$scale+$y);
    $pdf->line(370*$scale+$x,724*$scale+$y,340*$scale+$x,724*$scale+$y);
    $pdf->line(7*$scale+$x,197*$scale+$y,7*$scale+$x,227*$scale+$y);
    $pdf->line(7*$scale+$x,197*$scale+$y,37*$scale+$x,197*$scale+$y);
    $pdf->line(370*$scale+$x,197*$scale+$y,370*$scale+$x,227*$scale+$y);
    $pdf->line(370*$scale+$x,197*$scale+$y,340*$scale+$x,197*$scale+$y);
    
    text_autosize(15*$scale+$x,568*$scale+$y,30*$scale, iconv("UTF-8","ISO-8859-2",$finances['shortname']),350*$scale);
    text_autosize(15*$scale+$x,534*$scale+$y,30*$scale, iconv("UTF-8","ISO-8859-2",$finances['address']),350*$scale);
    text_autosize(15*$scale+$x,500*$scale+$y,30*$scale, iconv("UTF-8","ISO-8859-2",$finances['zip']." ".$finances['city']),350*$scale);
    $tmp = bankaccount($invoice['customerid']);
    //text_autosize(15*$scale+$x,683*$scale+$y,30*$scale, substr($tmp,0,17),350*$scale);
    //text_autosize(15*$scale+$x,626*$scale+$y,30*$scale, substr($tmp,18,200),350*$scale);
    text_autosize(15*$scale+$x,683*$scale+$y,30*$scale, $tmp,350*$scale);
    text_autosize(15*$scale+$x,445*$scale+$y,30*$scale,"*".number_format($invoice['total'],2,',','')."*",350*$scale);

    text_autosize(15*$scale+$x,390*$scale+$y,30*$scale, iconv("UTF-8","ISO-8859-2",$invoice['name']),350*$scale);
    text_autosize(15*$scale+$x,356*$scale+$y,30*$scale, iconv("UTF-8","ISO-8859-2",$invoice['address']),350*$scale);
    text_autosize(15*$scale+$x,322*$scale+$y,30*$scale, iconv("UTF-8","ISO-8859-2",$invoice['zip']." ".$invoice['city']),350*$scale);

    $tmp = docnumber($invoice['number'], $invoice['template'], $invoice['cdate']);
    text_autosize(15*$scale+$x,215*$scale+$y,30*$scale,iconv("UTF-8","ISO-8859-2",trans('Payment for invoice No. $0',$tmp)),350*$scale);
}

function invoice_main_form_fill($x,$y,$scale)	
{
    global $pdf,$invoice,$CONFIG;
    $finances = $CONFIG['finances'];
    $pdf->setlinestyle(1);

    $pdf->line(7*$scale+$x,724*$scale+$y,7*$scale+$x,694*$scale+$y);
    $pdf->line(7*$scale+$x,724*$scale+$y,37*$scale+$x,724*$scale+$y);
    $pdf->line(970*$scale+$x,724*$scale+$y,970*$scale+$x,694*$scale+$y);
    $pdf->line(970*$scale+$x,724*$scale+$y,940*$scale+$x,724*$scale+$y);
    $pdf->line(7*$scale+$x,172*$scale+$y,7*$scale+$x,202*$scale+$y);
    $pdf->line(7*$scale+$x,172*$scale+$y,37*$scale+$x,172*$scale+$y);

    text_autosize(15*$scale+$x,680*$scale+$y,30*$scale,iconv("UTF-8","ISO-8859-2",$finances['name']),950*$scale);
    text_autosize(15*$scale+$x,617*$scale+$y,30*$scale,iconv("UTF-8","ISO-8859-2",$finances['address']." ".$finances['zip']." ".$finances['city']),950*$scale);
    text_autosize(15*$scale+$x,555*$scale+$y,30*$scale,bankaccount($invoice['customerid']),950*$scale);
    $pdf->addtext(330*$scale+$x,495*$scale+$y,30*$scale,'X');
    text_autosize(550*$scale+$x,495*$scale+$y,30*$scale,"*".number_format($invoice['total'],2,',','')."*",400*$scale);
    text_autosize(15*$scale+$x,434*$scale+$y,30*$scale,iconv("UTF-8","ISO-8859-2",trans('$0 dollars $1 cents',to_words(floor($invoice['total'])),to_words(round(($invoice['total']-floor($invoice['total']))*100)))),950*$scale);
    text_autosize(15*$scale+$x,372*$scale+$y,30*$scale, iconv("UTF-8","ISO-8859-2",$invoice['name']),950*$scale);
    text_autosize(15*$scale+$x,312*$scale+$y,30*$scale, iconv("UTF-8","ISO-8859-2",$invoice['address']." ".$invoice['zip']." ".$invoice['city']),950*$scale);
    $tmp = docnumber($invoice['number'], $invoice['template'], $invoice['cdate']);
    text_autosize(15*$scale+$x,250*$scale+$y,30*$scale,iconv("UTF-8","ISO-8859-2",trans('Payment for invoice No. $0',$tmp)),950*$scale);
}

function invoice_dates($x,$y)
{
    global $invoice,$pdf;
    $font_size=12;
    text_align_right($x,$y,$font_size,iconv("UTF-8","ISO-8859-2",trans('Settlement date:')).' ');
    $y=$y-text_align_left($x,$y,$font_size,date("Y/m/d",$invoice['cdate']));
    text_align_right($x,$y,$font_size,iconv("UTF-8","ISO-8859-2",trans('Sale date:')).' ');
    $y=$y-text_align_left($x,$y,$font_size,date("Y/m/d",$invoice['cdate']));
    text_align_right($x,$y,$font_size,iconv("UTF-8","ISO-8859-2",trans('Deadline:')).' ');
    $y=$y-text_align_left($x,$y,$font_size,date("Y/m/d",$invoice['pdate']));
    text_align_right($x,$y,$font_size,iconv("UTF-8","ISO-8859-2",trans('Payment type:')).' ');
    $y=$y-text_align_left($x,$y,$font_size,iconv("UTF-8","ISO-8859-2",$invoice['paytype']));
    return $y;
}

function invoice_buyer($x,$y) 
{
    global $invoice,$pdf;
    $font_size=10;
    $y=$y-text_align_left($x,$y,$font_size,'<b>'.iconv("UTF-8","ISO-8859-2",trans('Purchaser:')).'</b>');
    $y=text_wrap($x,$y,350,$font_size,iconv("UTF-8","ISO-8859-2",$invoice['name']),'left');
    $y=$y-text_align_left($x,$y,$font_size,iconv("UTF-8","ISO-8859-2",$invoice['address']));
    $y=$y-text_align_left($x,$y,$font_size,iconv("UTF-8","ISO-8859-2",$invoice['zip']." ".$invoice['city']));
    if ($invoice['ten']) 
	$y=$y-text_align_left($x,$y,$font_size,iconv("UTF-8","ISO-8859-2",trans('TEN:')).' '.$invoice['ten']);
    else if ($invoice['ssn']) 
	$y=$y-text_align_left($x,$y,$font_size,iconv("UTF-8","ISO-8859-2",trans('SSN:')).' '.$invoice['ssn']);
    $y=$y-text_align_left($x,$y,$font_size,'<b>'.iconv("UTF-8","ISO-8859-2",trans('Customer No.: $0',sprintf('%04d',$invoice['customerid']))).'</b>');
    return $y;
}

function invoice_seller($x,$y) 
{
    global $pdf,$CONFIG;
    $font_size=10;
    $y=$y-text_align_left($x,$y,$font_size,'<b>'.iconv("UTF-8","ISO-8859-2",trans('Seller:')).'</b>');
    $tmp = iconv("UTF-8","ISO-8859-2",$CONFIG['invoices']['header']);
    $tmp = str_replace('\n',"\n",$tmp);
    $tmp = explode("\n",$tmp);
    foreach ($tmp as $line) $y=$y-text_align_left($x,$y,$font_size,$line);

    return $y;
}

function invoice_title($x,$y) 
{
    global $invoice,$pdf,$CONFIG,$type;
    $font_size = 16;
    $tmp = docnumber($invoice['number'], $invoice['template'], $invoice['cdate']);
    if($invoice['invoice'])
    	$y=$y-text_align_left($x,$y,$font_size,'<b>'.iconv("UTF-8","ISO-8859-2",trans('Credit Note No. $0',$tmp)).'</b>');
    else
	$y=$y-text_align_left($x,$y,$font_size,'<b>'.iconv("UTF-8","ISO-8859-2",trans('Invoice No. $0',$tmp)).'</b>');
    
    if($invoice['invoice'])
    {
	$font_size = 12; $y += 8;
	$tmp = docnumber($invoice['invoice']['number'], $invoice['invoice']['template'], $invoice['invoice']['cdate']);
	$y=$y-text_align_left($x,$y,$font_size,'<b>'.iconv("UTF-8","ISO-8859-2",trans('for Invoice No. $0',$tmp)).'</b>');
	$y -= 5;
    }
    
    $font_size = 16;
    $y=$y-text_align_left($x,$y,$font_size,iconv("UTF-8","ISO-8859-2",$type));
    
    if($invoice['invoice'])
    	$y += 10;
    return $y;
}

function invoice_address_box($x,$y) 
{
    global $invoice,$pdf;
    $font_size=12;
/*
    $invoice_name = $invoice['name'];
    if (strlen($invoice_name)>25) 
        $invoice_name = preg_replace('/(.{25})/',"$1<i>&gt;</i>\n",$invoice_name);
    $tmp = explode("\n",iconv("UTF-8","ISO-8859-2",$invoice_name));
    foreach ($tmp as $line) $y=$y-text_align_left($x,$y,$font_size,"<b>".$line."</b>");
*/
    $y = text_wrap($x, $y, 160, $font_size, iconv("UTF-8","ISO-8859-2",$invoice['name']), 'left');
    if ($invoice['serviceaddr']) {
	$tmp = explode("\n",iconv("UTF-8","ISO-8859-2",$invoice['serviceaddr']));
	foreach ($tmp as $line) $y=$y-text_align_left($x,$y,$font_size,"<b>".$line."</b>");
    } else {
	$y=$y-text_align_left($x,$y,$font_size,"<b>".iconv("UTF-8","ISO-8859-2",$invoice['address'])."</b>");
	$y=$y-text_align_left($x,$y,$font_size,"<b>".iconv("UTF-8","ISO-8859-2",$invoice['zip']." ".$invoice['city'])."</b>");
    }
    return $y;
}

function invoice_data_row($x,$y,$width,$font_size,$margin,$data,$t_width,$t_justify) 
{
    global $pdf;
    $fy=$y-$margin-$pdf->GetFontHeight($font_size);    
    $left = $x+$margin;
    $ny = $fy;
    for ($i = 1; $i <= 10; $i++) {
	$ly = text_wrap($left+$margin, $fy, $t_width[$i]-2*$margin, $font_size,$data[$i],$t_justify[$i]);
	$left = $left + $t_width[$i]+2*$margin;
	if ($ly<$ny) $ny=$ly;
    }
    $left = $x;
    for ($i = 1; $i <= 10; $i++) {
	$pdf->line($left, $y, $left, $ny);
	$left = $left + $t_width[$i]+2*$margin;
    }
    $pdf->line($left, $y, $left, $ny);
    $y=$ny;
    $pdf->line($x,$y,$x+$width,$y);
    return($y);
}

function invoice_short_data_row($x,$y,$width,$font_size,$margin,$data,$t_width,$t_justify) 
{
    global $pdf;
    $fy=$y-$margin-$pdf->GetFontHeight($font_size);    
    $left = $x+$margin;
    $ny = $fy;
    for ($i = 7; $i <= 10; $i++) {
	$ly = text_wrap($left+$margin, $fy, $t_width[$i]-2*$margin, $font_size,$data[$i],$t_justify[$i]);
	$left = $left + $t_width[$i]+2*$margin;
	if ($ly<$ny) $ny=$ly;
    }
    $left = $x;
    for ($i = 7; $i <= 10; $i++) {
	$pdf->line($left, $y, $left, $ny);
	$left = $left + $t_width[$i]+2*$margin;
    }
    $pdf->line($left, $y, $left, $ny);
    $y=$ny;
    //$pdf->line($x,$y,$x+$width,$y);
    $pdf->line($x,$y,$x+$t_width[7]+$t_width[8]+$t_width[9]+$t_width[10]+8*$margin,$y);
    return($y);
}

function invoice_data($x,$y,$width,$font_size,$margin) 
{
    global $invoice,$pdf;
    $pdf->setlinestyle(0.5);
    $pdf->line($x,$y,$x+$width,$y);
    $t_data[1] = '<b>'.iconv("UTF-8","ISO-8859-2",trans('No.')).'</b>';
    $t_data[2] = '<b>'.iconv("UTF-8","ISO-8859-2",trans('Name of Product, Commodity or Service:')).'</b>';
    $t_data[3] = '<b>'.iconv("UTF-8","ISO-8859-2",trans('Product ID:')).'</b>';
    $t_data[4] = '<b>'.iconv("UTF-8","ISO-8859-2",trans('Unit:')).'</b>';
    $t_data[5] = '<b>'.iconv("UTF-8","ISO-8859-2",trans('Amount:')).'</b>';
    $t_data[6] = '<b>'.iconv("UTF-8","ISO-8859-2",trans('Unitary Net Value:')).'</b>';
    $t_data[7] = '<b>'.iconv("UTF-8","ISO-8859-2",trans('Net Value:')).'</b>';
    $t_data[8] = '<b>'.iconv("UTF-8","ISO-8859-2",trans('Tax Rate:')).'</b>';
    $t_data[9] = '<b>'.iconv("UTF-8","ISO-8859-2",trans('Tax Value:')).'</b>';
    $t_data[10] = '<b>'.iconv("UTF-8","ISO-8859-2",trans('Gross Value:')).'</b>';
    for ($i = 1; $i <= 10; $i++) $t_justify[$i]="left";
    for ($i = 1; $i <= 10; $i++) $t_width[$i]=$pdf->getTextWidth($font_size,$t_data[$i])+2*$margin+1;
    // tutaj jeszcze trzeba b�dzie sprawdzi� jak� szeroko�� maj� pola w tabelce p�niej
    if ($invoice['content']) foreach ($invoice['content'] as $item) {
	$tt_width[2] = $pdf->getTextWidth($font_size,iconv("UTF-8","ISO-8859-2",$item['description']));
	$tt_width[3] = $pdf->getTextWidth($font_size,$item['prodid']);
	$tt_width[4] = $pdf->getTextWidth($font_size,$item['content']);
	$tt_width[5] = $pdf->getTextWidth($font_size,$item['count']);
	$tt_width[6] = $pdf->getTextWidth($font_size,iconv("UTF-8","ISO-8859-2",moneyf($item['basevalue'])));
	$tt_width[7] = $pdf->getTextWidth($font_size,iconv("UTF-8","ISO-8859-2",moneyf($item['totalbase'])));
	$tt_width[8] = $pdf->getTextWidth($font_size,iconv("UTF-8","ISO-8859-2",$item['taxlabel']));
	$tt_width[9] = $pdf->getTextWidth($font_size,iconv("UTF-8","ISO-8859-2",moneyf($item['totaltax'])));
	$tt_width[10] = $pdf->getTextWidth($font_size,iconv("UTF-8","ISO-8859-2",moneyf($item['total'])));
	for ($i = 2; $i <= 5; $i++) if (($tt_width[$i]+2*margin+2)>$t_width[$i]) $t_width[$i]=$tt_width[$i]+2*margin+2;
    }    
    // Kolumna 2 b�dzie mia�a rozmiar ustalany dynamicznie
    $t_width[2] = $width-($t_width[1]+$t_width[3]+$t_width[4]+$t_width[5]+$t_width[6]+$t_width[7]+$t_width[8]+$t_width[9]+$t_width[10]+20*$margin);
    $y = invoice_data_row($x,$y,$width,$font_size,$margin,$t_data,$t_width,$t_justify);
    $t_justify[10] = $t_justify[9] = $t_justify[8] = $t_justify[7] = $t_justify[6] = $t_justify[5] = "right";

    if($invoice['invoice'])
    {
	// we have credit note, so first print corrected invoice data
	$xx = $x;
        $y = $y-text_align_left($x,$y-10,$font_size,'<b>'.iconv("UTF-8","ISO-8859-2",trans('Was:')).'</b>');
	$y -= 6;
	$pdf->line($x,$y,$x+$width,$y);
	$lp = 1;
	if ($invoice['invoice']['content']) 
	    foreach ($invoice['invoice']['content'] as $item)
	    {
		$t_data[1] = $lp;
		$t_data[2] = iconv("UTF-8","ISO-8859-2",$item['description']);
		$t_data[3] = $item['prodid'];
		$t_data[4] = $item['content'];
		$t_data[5] = sprintf('%.2f',$item['count']);
		$t_data[6] = iconv("UTF-8","ISO-8859-2",moneyf($item['basevalue']));
		$t_data[7] = iconv("UTF-8","ISO-8859-2",moneyf($item['totalbase']));
		$t_data[8] = iconv("UTF-8","ISO-8859-2",$item['taxlabel']);
		$t_data[9] = iconv("UTF-8","ISO-8859-2",moneyf($item['totaltax']));
		$t_data[10] = iconv("UTF-8","ISO-8859-2",moneyf($item['total']));
	
		$lp++;
		$y = invoice_data_row($x,$y,$width,$font_size,$margin,$t_data,$t_width,$t_justify);
	    }
    
        $x = $x + 12*$margin + $t_width[1] + $t_width[2] + $t_width[3] + $t_width[4] + $t_width[5] + $t_width[6];

        $fy=$y-$margin-$pdf->GetFontHeight($font_size);    
	text_align_right($x-$margin,$fy,$font_size,'<b>'.iconv("UTF-8","ISO-8859-2",trans('Total:')).'</b>');
    
	$t_data[7] = iconv("UTF-8","ISO-8859-2",moneyf($invoice['invoice']['totalbase']));
        $t_data[8] = "<b>x</b>";
	$t_data[9] = iconv("UTF-8","ISO-8859-2",moneyf($invoice['invoice']['totaltax']));
        $t_data[10] = iconv("UTF-8","ISO-8859-2",moneyf($invoice['invoice']['total']));
    
	$y = invoice_short_data_row($x,$y,$width,$font_size,$margin,$t_data,$t_width,$t_justify);
        $y -= 5;

	$fy=$y-$margin-$pdf->GetFontHeight($font_size);    
        text_align_right($x-$margin,$fy,$font_size,'<b>'.iconv("UTF-8","ISO-8859-2",trans('in it:')).'</b>');
	$pdf->line($x,$y,$x+$t_width[7]+$t_width[8]+$t_width[9]+$t_width[10]+8*$margin,$y);
    
	if ($invoice['invoice']['taxest']) 
	    foreach ($invoice['invoice']['taxest'] as $item) 
	    {
		$t_data[7] = iconv("UTF-8","ISO-8859-2",moneyf($item['base']));
		$t_data[8] = iconv("UTF-8","ISO-8859-2",$item['taxlabel']);
		$t_data[9] = iconv("UTF-8","ISO-8859-2",moneyf($item['tax']));
		$t_data[10] = iconv("UTF-8","ISO-8859-2",moneyf($item['total']));
		$y = invoice_short_data_row($x,$y,$width,$font_size,$margin,$t_data,$t_width,$t_justify);
	    }
	
	$x = $xx;
	$y = $y-text_align_left($x,$y-10,$font_size,'<b>'.iconv("UTF-8","ISO-8859-2",trans('Corrected to:')).'</b>');
	$y -= 5;
	$pdf->line($x,$y,$x+$width,$y);
    }
        
    $lp = 1;
    if ($invoice['content']) foreach ($invoice['content'] as $item)
    {
	$t_data[1] = $lp;
	$t_data[2] = iconv("UTF-8","ISO-8859-2",$item['description']);
	$t_data[3] = $item['prodid'];
	$t_data[4] = $item['content'];
	$t_data[5] = sprintf('%.2f',$item['count']);
	$t_data[6] = iconv("UTF-8","ISO-8859-2",moneyf($item['basevalue']));
	$t_data[7] = iconv("UTF-8","ISO-8859-2",moneyf($item['totalbase']));
	$t_data[8] = iconv("UTF-8","ISO-8859-2",$item['taxlabel']);
	$t_data[9] = iconv("UTF-8","ISO-8859-2",moneyf($item['totaltax']));
	$t_data[10] = iconv("UTF-8","ISO-8859-2",moneyf($item['total']));
	
	$lp++;
	$y = invoice_data_row($x,$y,$width,$font_size,$margin,$t_data,$t_width,$t_justify);
    }
    
    $return[1] = $y;
    
    $x = $x + 12*$margin + $t_width[1] + $t_width[2] + $t_width[3] + $t_width[4] + $t_width[5] + $t_width[6];

    $fy=$y-$margin-$pdf->GetFontHeight($font_size);    
    text_align_right($x-$margin,$fy,$font_size,'<b>'.iconv("UTF-8","ISO-8859-2",trans('Total:')).'</b>');
    
    $t_data[7] = iconv("UTF-8","ISO-8859-2",moneyf($invoice['totalbase']));
    $t_data[8] = "<b>x</b>";
    $t_data[9] = iconv("UTF-8","ISO-8859-2",moneyf($invoice['totaltax']));
    $t_data[10] = iconv("UTF-8","ISO-8859-2",moneyf($invoice['total']));

    $y = invoice_short_data_row($x,$y,$width,$font_size,$margin,$t_data,$t_width,$t_justify);
    
    $y = $y - 5;

    $fy=$y-$margin-$pdf->GetFontHeight($font_size);    
    text_align_right($x-$margin,$fy,$font_size,'<b>'.iconv("UTF-8","ISO-8859-2",trans('in it:')).'</b>');
    $pdf->line($x,$y,$x+$t_width[7]+$t_width[8]+$t_width[9]+$t_width[10]+8*$margin,$y);
    
    if ($invoice['taxest']) foreach ($invoice['taxest'] as $item) 
    {
	$t_data[7] = iconv("UTF-8","ISO-8859-2",moneyf($item['base']));
	$t_data[8] = iconv("UTF-8","ISO-8859-2",$item['taxlabel']);
	$t_data[9] = iconv("UTF-8","ISO-8859-2",moneyf($item['tax']));
	$t_data[10] = iconv("UTF-8","ISO-8859-2",moneyf($item['total']));
	$y = invoice_short_data_row($x,$y,$width,$font_size,$margin,$t_data,$t_width,$t_justify);
    }
    $return[2] = $y;

    return $return;
}

function invoice_to_pay($x,$y) 
{
    global $pdf, $invoice;
    if($invoice['rebate'])
	    $y = $y - text_align_left($x,$y,14,iconv("UTF-8","ISO-8859-2",trans('To repay:')).' '.iconv("UTF-8","ISO-8859-2",moneyf($invoice['value'])));
    else
	    $y = $y - text_align_left($x,$y,14,iconv("UTF-8","ISO-8859-2",trans('To pay:')).' '.iconv("UTF-8","ISO-8859-2",moneyf($invoice['value'])));
    $y = $y - text_align_left($x,$y,10,iconv("UTF-8","ISO-8859-2",trans('In words:')).' '.iconv("UTF-8","ISO-8859-2",trans('$0 dollars $1 cents',to_words(floor($invoice['value'])),to_words(round(($invoice['value']-floor($invoice['value']))*100)))));
    return $y;
}

function invoice_expositor ($x,$y) 
{
    global $pdf, $CONFIG;
    $y = $y - text_align_left($x,$y,10,iconv("UTF-8","ISO-8859-2",trans('Expositor:')).' '.iconv("UTF-8","ISO-8859-2",$CONFIG['invoices']['default_author']));
    return $y;
}

function invoice_footnote($x, $y, $width, $font_size) 
{
    global $pdf, $CONFIG;
    if ($CONFIG['invoices']['footer']) {
	$y = $y - $pdf->getFontHeight($font_size);
	$y = $y - text_align_left($x,$y,$font_size,'<b>'.iconv("UTF-8","ISO-8859-2",trans('Notes:')).'</b>');
	$tmp = iconv("UTF-8","ISO-8859-2",$CONFIG['invoices']['footer']);
	$tmp = str_replace('\n',"\n",$tmp);
        $tmp = explode("\n",$tmp);
	foreach ($tmp as $line) $y = text_wrap($x,$y,$width,$font_size,$line,"full");
    }
}

function invoice_body() 
{
    global $invoice,$pdf,$id,$CONFIG;
    
    if($invoice['invoice'])
	    $template = $CONFIG['invoices']['cnote_template_file'];
    else
	    $template = $CONFIG['invoices']['template_file'];

    switch ($template)
    {
	case "standard":
	    $top=800;
	    invoice_dates(500,800);    
    	    invoice_address_box(400,700);
	    $top=invoice_title(30,$top);
	    $top=$top-20;
    	    $top=invoice_seller(30,$top);
	    $top=$top-20;
    	    $top=invoice_buyer(30,$top);
	    $top=$top-20;
    	    $return=invoice_data(30,$top,530,7,2);
	    invoice_expositor(30,$return[1]-20);
    	    $top=$return[2]-20;
	    $top=invoice_to_pay(30,$top);
	    $top=$top-20;
	    invoice_footnote(30,$top,530,10);
	    break;
	case "FT-0100":
	    $top=800;
	    invoice_dates(500,800);    
    	    invoice_address_box(400,700);
	    $top=invoice_title(30,$top);
	    $top=$top-10;
    	    $top=invoice_seller(30,$top);
	    $top=$top-10;
    	    $top=invoice_buyer(30,$top);
	    $top=$top-10;
    	    $return=invoice_data(30,$top,430,6,1);
	    invoice_footnote(470,$top,90,8);
	    invoice_expositor(30,$return[1]-20);
    	    $top=$return[2]-10;
	    invoice_to_pay(30,$top);
	    invoice_main_form_fill(187,3,0.4);
	    invoice_simple_form_fill(14,3,0.4);
	    break;
	default:
	    require($template);
    }
    if (!($invoice['last'])) $id=$pdf->newPage(1,$id,'after');
}

// brzydki hack dla ezpdf 
setlocale(LC_ALL,'C');
require_once($_LIB_DIR.'/ezpdf/class.ezpdf.php');

$diff=array(177=>'aogonek',161=>'Aogonek',230=>'cacute',198=>'Cacute',234=>'eogonek',202=>'Eogonek',
241=>'nacute',209=>'Nacute',179=>'lslash',163=>'Lslash',182=>'sacute',166=>'Sacute',
188=>'zacute',172=>'Zacute',191=>'zdot',175=>'Zdot');
//$pdf =& new Cezpdf('A4','landscape');
$pdf =& new Cezpdf('A4','portrait');
$pdf->addInfo('Producer','LMS Developers');
$pdf->addInfo('Title',iconv("UTF-8","ISO-8859-2",trans('Invoices')));
$pdf->addInfo('Creator','LMS '.$layout['lmsv']);
$pdf->setPreferences('FitWindow','1');
$pdf->ezSetMargins(0,0,0,0);
$tmp = array(
    'b'=>'arialbd.afm',
);
$pdf->setFontFamily('arial.afm',$tmp);

$pdf->selectFont($_LIB_DIR.'/ezpdf/arialbd.afm',array('encoding'=>'WinAnsiEncoding','differences'=>$diff));
$pdf->selectFont($_LIB_DIR.'/ezpdf/arial.afm',array('encoding'=>'WinAnsiEncoding','differences'=>$diff));

$id=$pdf->getFirstPageId();

if($_GET['print'] == 'cached')
{
	$SESSION->restore('ilm', $ilm);
	$SESSION->remove('ilm');

	if(sizeof($_POST['marks']))
		foreach($_POST['marks'] as $id => $mark)
			$ilm[$id] = $mark;

	if(sizeof($ilm))
		foreach($ilm as $mark)
			$ids[] = $mark;

	if(!sizeof($ids))
	{
		$SESSION->close();
		die;
	}

	if($_GET['cash'])
	{
		foreach($ids as $cashid)
			if($invoiceid = $DB->GetOne('SELECT docid FROM cash, documents WHERE docid = documents.id AND documents.type = 1 AND cash.id = ?', array($cashid)))
				$idsx[] = $invoiceid;
		
		$ids = array_unique((array)$idsx);
	}

	sort($ids);
	$which = ($_GET['which'] != '' ? $_GET['which'] : trans('ORIGINAL+COPY'));
	$count = (strstr($which,'+') ? sizeof($ids)*2 : sizeof($ids));
	$i=0;

	foreach($ids as $idx => $invoiceid)
	{
		$invoice = $LMS->GetInvoiceContent($invoiceid);
		$invoice['serviceaddr'] = $LMS->GetCustomerServiceAddress($invoice['customerid']);
		foreach(split('\+', $which) as $type)
		{
			$i++;
			if($i == $count) $invoice['last'] = 1;
			invoice_body();
		}
	}
}
elseif($_GET['fetchallinvoices'])
{
	$which = ($_GET['which'] != '' ? $_GET['which'] : trans('ORIGINAL+COPY'));
	
	$ids = $DB->GetCol('SELECT id FROM documents
				WHERE cdate > ? AND cdate < ? AND type = 1'
				.($_GET['customerid'] ? ' AND customerid = '.$_GET['customerid'] : '')
				.' ORDER BY cdate',
				array($_GET['from'], $_GET['to']));
	if(!$ids)
	{
		$SESSION->close();
		die;
	}

	$count = (strstr($which,'+') ? sizeof($ids)*2 : sizeof($ids));
	$i=0;

	foreach($ids as $idx => $invoiceid)
	{
		$invoice = $LMS->GetInvoiceContent($invoiceid);
		$invoice['serviceaddr'] = $LMS->GetCustomerServiceAddress($invoice['customerid']);
		foreach(split('\+', $which) as $type)
		{
			$i++;
			if($i == $count) $invoice['last'] = 1;
			invoice_body();
		}
	}
}
elseif($_GET['fetchsingle'])
{
	$invoice = $LMS->GetInvoiceContent($_GET['id']);
	$invoice['last'] = TRUE;
	$invoice['serviceaddr'] = $LMS->GetCustomerServiceAddress($invoice['customerid']);
	$type = trans('ORIGINAL');
	invoice_body();

}
elseif($invoice = $LMS->GetInvoiceContent($_GET['id']))
{
	$invoice['serviceaddr'] = $LMS->GetCustomerServiceAddress($invoice['customerid']);
	$type = trans('ORIGINAL');
	invoice_body();
	$type = trans('COPY');
	$invoice['last'] = TRUE;
	invoice_body();
}
else
{
	$SESSION->redirect('?m=invoicelist');
}

$pdf->ezStream();

?>