<?php
require_once( "fpdf/fpdf.php" );
require_once 'key/db_connection.php';
require_once 'key/viewNomy3.php';
require_once 'key/authorize4.php';
header("Content-Type: text/html; charset=utf-8");
// Начало конфигурации


$textColour = array( 0, 0, 0 );
$headerColour = array( 100, 100, 100 );
$tableHeaderTopTextColour = array( 255, 255, 255 );
$tableHeaderTopFillColour = array( 125, 152, 179 );
$tableHeaderTopProductTextColour = array( 0, 0, 0 );
$tableHeaderTopProductFillColour = array( 143, 173, 204 );
$tableHeaderLeftTextColour = array( 99, 42, 57 );
$tableHeaderLeftFillColour = array( 184, 207, 229 );
$tableBorderColour = array( 50, 50, 50 );
$tableRowFillColour = array( 213, 170, 170 );
$reportName = "2018 Widget Sales Report";
$reportNameYPos = 160;
$logoFile = "image/road1.jpg";
$logoXPos = 0;
$logoYPos = 0;
$logoWidth = 296;
$rowLabels = array( "sent1", "sent2", "sent3", "sent4" );

$columnLabels = array( "Операция ID", "Время выполнения", "Название", "Описание", "Ответственный ID", "FIO Ответственного" );
$chartXPos = 20;
$chartYPos = 250;
$chartWidth = 160;
$chartHeight = 80;
$chartXLabel = "Water maker";
$chartYLabel = "2018 Sales";
$chartYStep = 20000;

$chartColours = array(
                  array( 255, 100, 100 ),
                  array( 100, 255, 100 ),
                  array( 100, 100, 255 ),
                  array( 255, 255, 100 ),
                );

// Создание инструкции SELECT
$select_users = "SELECT * FROM tp";
// Запуск запроса
$data = mysql_query($select_users);
/* 
$data = array(
          array( 9940, 10100, 9490, 11730 ),
          array( 19310, 21140, 20560, 22590 ),
          array( 25110, 26260, 25210, 28370 ),
          array( 27650, 24550, 30040, 31980 ),
        ); */

// Конец конфигурации


//title
$pdf = new FPDF( 'P', 'mm', 'A4' );
$pdf->SetTextColor( $textColour[0], $textColour[1], $textColour[2] );
$pdf->AddFont('ArialRus', '', 'Arial.php');//настройк ашрифта Arial
$pdf->AddPage();
// Логотип
$pdf->Image( $logoFile, $logoXPos, $logoYPos, $logoWidth );

// Название отчета
$pdf->SetFont('Arial', 'B', 12);
$pdf->Ln( $reportNameYPos );
$pdf->Cell( 0, 15, $reportName, 0, 0, 'C' );

$pdf->AddPage();
$pdf->SetTextColor( $headerColour[0], $headerColour[1], $headerColour[2] );
$pdf->SetFont( 'ArialRus', '', 14 );
$pdf->Cell( 0, 15, $reportName, 0, 0, 'C' );

$pdf->SetTextColor( $textColour[0], $textColour[1], $textColour[2] );
$pdf->SetFont( 'ArialRus', '', 14 );
$pdf->Write( 19, "2018 Was A Good Year for every month" );

// table
$pdf->SetDrawColor( $tableBorderColour[0], $tableBorderColour[1], $tableBorderColour[2] );
$pdf->Ln( 15 );

// Создаем строку заголовков таблицы
$pdf->SetFont( 'ArialRus', '', 12 );

// Ячейка "PRODUCT"
/* $pdf->SetTextColor( $tableHeaderTopProductTextColour[0], $tableHeaderTopProductTextColour[1], $tableHeaderTopProductTextColour[2] );
$pdf->SetFillColor( $tableHeaderTopProductFillColour[0], $tableHeaderTopProductFillColour[1], $tableHeaderTopProductFillColour[2] );
$pdf->Cell( 27, 12, " Water maker", 1, 0, 'L', true ); */

// Остальные ячейки заголовков
$pdf->SetTextColor( $tableHeaderTopTextColour[0], $tableHeaderTopTextColour[1], $tableHeaderTopTextColour[2] );
$pdf->SetFillColor( $tableHeaderTopFillColour[0], $tableHeaderTopFillColour[1], $tableHeaderTopFillColour[2] );

for ( $i=0; $i<count($columnLabels); $i++ ) {
  $pdf->Cell( 27, 12, $columnLabels[$i], 1, 0, 'C', true );
}

$pdf->Ln( 12 );

// Создаем строки с данными

$fill = false;
$row = 0;
// circle data
while ($tp = mysql_fetch_array($data)) {

/*   // Создаем левую ячейку с заголовком строки
  $pdf->SetFont( 'ArialRus', '', 12 );
  $pdf->SetTextColor( $tableHeaderLeftTextColour[0], $tableHeaderLeftTextColour[1], $tableHeaderLeftTextColour[2] );
  $pdf->SetFillColor( $tableHeaderLeftFillColour[0], $tableHeaderLeftFillColour[1], $tableHeaderLeftFillColour[2] );
  $pdf->Cell( 27, 12, " " . $rowLabels[$row], 1, 0, 'L', $fill ); */

  // Создаем ячейки с данными
  $pdf->SetTextColor( $textColour[0], $textColour[1], $textColour[2] );
  $pdf->SetFillColor( $tableRowFillColour[0], $tableRowFillColour[1], $tableRowFillColour[2] );
  $pdf->SetFont( 'ArialRus', '', 12 );

  for ( $i=0; $i<count($columnLabels); $i++ ) {
    $pdf->Cell( 27, 12, ( $tp[$i]), 1);	//, 0, 'C', $fill 
  }

  $row++;
  $fill = !$fill;
  $pdf->Ln( 12 );
}

/***  Выводим PDF ***/

$pdf->Output( "report.pdf", "I" );




/*/fgh
<?php
$ s =oci_connect('hr', 'hr', 'scfx');
$query="SELECT Salary FROM
(SELECT salary,Max(Hire_Date) Hire_Date
FROM (SELECT Hire_Date,sal ary
FROM (SELECT Hire_Date,sal ary FROM Employees ORDER BY Hire_Date Desc,salary DESC)
WHERE ROWNUM<=50)
GROUP BY salary ORDER BY 2 desc)
WHERE ROWNLIM<20";
$c=oci parse($s, $ query); ociexecute($c,OCl_DEFAULT);
@i nclude('fpdf/fpdf.php');
if (@$pdf=new FPDF())
$pdf->AddFont('ArialRus', ''Arial.php');
$pdf->AddPage();
$pdf->setFont(1Ari alRus', '12);
$x=20;
$y=20;
wh i1e ($ f=о c i _f et c h_r ow ( $ c))
{
echo ($f[0].'<br>');
$pdf->text($x,$y,$f[0]);
$y=$y+10;
$fi1ename='8_2_4. pdf' ; 
$pdf->output($fi1ename)
oci commit($s) oci1ogoff($s) ;
?>

<?php
$s=oci_connectС hr', 'hr', 'scfx');
$query="SELECT salary FROM
(SELECT salary,Max(Hlre_Date) Hire_Date
FROM (SELECT Hire_Date,sal ary
FROM (SELECT Hire_Date,sal ary FROM Employees ORDER BY Hire_Date Desc,salary DESC)
WHERE ROWNUM<«5Q)
GROUP BY salary ORDER BY 2 desc)
WHERE ROWNUM<20";
$c=oci par 5e(Is,$query);
□ci execute(Ic,oci_DEFAULT);
@i ncludef'fpdf/fpdf.php'); einclude('trans. php');
if (®$pdf=new FPDF0)
$pdf->AddFont('Aria!Rus',	'Arial.php');
$ pdf-xAddFont('barcode', ' ','barcode.php');
$pdf->AddPage();
$x=2Q;
$y=20;
while ($f«oci_fetch_row($c"ii
{
echo (If[0].'<br>');
$pdf->setFont('Ari alRUS',	12);
$pdf->text($x,ty, $f [0]);
$pdf->setFont('barcode','','10'); $pdf->text($x+40, $y, codabar_ch($f [0]));
Iy=ly+1Q;
$fi 1ename='8_2_4.pdf' ; $pdf->Output($fi1ename);
oci commit(Is); 
oci1ogoff(is);

//------------------------------\]

*/

?>