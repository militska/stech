<?php$stech = node_load($nid);global $base_url;$status = db_select('stech_status_log','sl')			->fields('sl',				array('sid'))			-> orderBy('sl.date','DESC')			->condition('nid',$stech->nid,'=')			-> range(0,1)			->execute()			->FetchField();print '<div class="full_basis_block">';print '<b>Номер заказа </b>   '.($stech->nid).'<br>';print '<b>Текущий статус  </b>'.taxonomy_term_load($status)->name.'<br><br>';;if (user_access('profile_eng')) {		print '<b>Клиент</b>   '.($stech->fam).' '.($stech->name_cl).' '.($stech->otch).' '.'<br>';	print '<b>Номер телефона </b>   '.($stech->phone_client).'<br><br>';}else{print '';}	print '<b>Описание неисправности </b>   '.($stech->problem).'<br>';print '<b>Конфигурация </b>   '.($stech->confs).'<br><br>';print '</div><br><h3>Действия</h3><br>';print "<a href='".$base_url."/stech_tek_log_req/".$stech->nid."'>Текущая история заявк</a></br>";if ($status == 8) {print "<a href='".$base_url."/stech_req_rep_client/".$stech->nid."'>Начальный отчет</a></br>";}if ($status == 14) {print "<a href='".$base_url."/stech_rep_act_itog/".$stech->nid."'>Итоговая бумаженция</a></br>";}if ($status<>8) {print " <a href='".$base_url."/stech_req_ac/".$stech->nid."/".'13'."'><b>Отказаться</b></a><br>";}if ($status==12) {	print " <a href='".$base_url."/stech_req_ac/".$stech->nid."/".'9'."'><b>Вернуть по гарантии</b></a><br>";}		$header = array(		array('data' => 'Дата'),				array('data' => 'Пользователь'),		array('data' => 'Статус'),					array('data' => 'Комментарий'),			);	$q=db_select('stech_status_log','sl')	->fields('sl',				array('sid','date','uid','comment'))			-> orderBy('sl.date','ASC')			->condition('nid',$stech->nid,'=')	->execute();		foreach ($q as $record) {$rows[] = array(		 date('d.m.Y',$record->date),		 user_load($record->uid)->name,		 taxonomy_term_load($record->sid)->name,		 $record->comment,			 );  	}	print theme('table', array('header' => $header, 'rows' => $rows));?>