<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="utf-8">
	<title>Счет №{$id}</title>
	<style type="text/css">
body{
	font: 14px/18px Arial;
	margin: 0;
	padding: 0;
	background: #fff;
}
/* bill styles */
.bill-print{
	padding: 30px 0;
}
.print-page{
	max-width: 640px;
}
.bill-print-p{	
	padding: 8px 0;
}
.bill-print-ptit{
	padding: 0 0 6px 0;
}
.bill-print-ptit span{
	display: inline-block;
	width: 120px;
	font-weight: bold;
}
.bill-print-rekv{
	padding-left: 30px;
}
table.print-rekv{	
	margin: 0;
	padding: 0;
	border-collapse: collapse;
	border-spacing: 0;
}
table.print-rekv  td{
	border: 0 !important;
	vertical-align: top; 
	padding: 3px 0 !important;
}
table.print-rekv  td.first-td{
	width: 140px;
	font-weight: bold;
}
.bill-print-comment{
	text-align: center;
	padding: 20px;
	font-size: 16px;
	text-decoration: underline;
	color: red;
}
.bill-print-num{
	text-align: center;
	padding: 14px 0 4px 0;
	font-size: 22px;
}
.bill-print-dt{
	text-align: center;
}

.bill-print-tbl{
	padding: 20px 0;
}
table.print-tbl{
	width: 100%;
	margin: 0;
	padding: 0;
	border-collapse: collapse;
	border-spacing: 0;
	/*border: 1px solid black;*/
}
th.t-th{
	border: 1px solid black;
}
table.print-tbl th{
	text-align: center;
	border: 1px solid black;
	font-weight: normal;
	padding: 14px 4px;
}
table.print-tbl td{
	border: 1px solid black !important;
	padding: 10px 4px !important;
}
table.print-tbl td.no-bord{
	border: 0 !important; text-align: right;
}

.bill-print-stamp{
	padding: 20px 0;
}
.bill-print-stamp>img{
	display: block; margin: 0 50px 0 auto;
}
	</style>
</head>
<body>
	<div class="bill-print">
			<div class="print-page">
				<div class="bill-print-p">
					<div class="bill-print-ptit"><span>Постачальник</span> ФОП Зiнченко Олександр Олексійович</div>
<div class="bill-print-rekv">
<table class="print-rekv">
<tr>
	<td class="first-td">IBAN</td>
	<td>UA713515330000026007052317785</td>
</tr>
<tr>
	<td class="first-td">Банк</td>
	<td>ПАТ КБ "ПриватБанк"</td>
</tr>
<tr>
	<td class="first-td">МФО</td>
	<td>351533</td>
</tr>
<tr>
	<td class="first-td">Свiд.</td>
	<td>24800000000117269</td>
</tr>
<tr>
	<td class="first-td">ІПН</td>
	<td>2741821150</td>
</tr>
<tr>
	<td class="first-td">Адреса:</td>
	<td>м.Харкiв, вул. Саперна 30, кв. 104</td>
</tr>
<tr>
	<td class="first-td"></td>
	<td><b>Платник единого податку</b></td>
</tr>
</table>
</div>
				</div>
				<div class="bill-print-p">
					<div class="bill-print-ptit"><span>Замовник:</span> {$name}</div>
				</div>
				<div class="bill-print-comment">В призначенні платежу обов'язково вказувати номер рахунку!!</div>
				<div class="bill-print-num">Рахунок-фактура № {$id}</div>
				<div class="bill-print-dt">вiд {$smarty.now|date_format:"%Y-%m-%d %H:%M:%S"}</div>
				<div class="bill-print-tbl">
					<table class="print-tbl">
					<tr>
						<th>№</th>
						<th class="t-th">Найменування робіт, послуг</th>
						<th>Од.</th>
						<th>Кіл-сть</th>
						<th>Ціна без<br>ПДВ</th>
						<th>Сума без<br>ПДВ</th>
					</tr>
					<tr>
						<td>1</td>
						<td>За iнформацiйнi послуги. Поповнення рахунку згiдно с/ф {$id}</td>
						<td>послуга</td>
						<td>1</td>
						<td>{$amount}.00</td>
						<td>{$amount}.00</td>
					</tr>
					<tr>
						<td colspan="5" class="no-bord">Всього без ПДВ</td>
						<td>{$amount}.00</td>
					</tr>
					<tr>
						<td colspan="5" class="no-bord">Сума ПДВ</td>
						<td>без ПДВ</td>
					</tr>
					<tr>
						<td colspan="5" class="no-bord">Разом</td>
						<td>{$amount}.00</td>
					</tr>
					</table>
				</div>
				<div class="bill-print-stamp">
					<img src="/app/assets/img/bill-stamp-zin.png" alt="">
				</div>
			</div>
		</div>
</body>
</html>