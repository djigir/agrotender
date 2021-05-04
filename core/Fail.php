<?php
namespace Core;
/**
 * Обработка ошибок и исключений
 */
class Fail extends \Exception {
  /**
   * Error handler. Convert all errors to Exceptions by throwing an ErrorException.
   *
   * @param int $level  Error level
   * @param string $message  Error message
   * @param string $file  Filename the error was raised in
   * @param int $line  Line number in the file
   *
   * @return void
   */
  /**
   * Exception handler.
   *
   * @param $e  The exception
   *
   * @return void
   */
  public static function exception($exception) {
    if ($exception->getCode() == 404) {
      (new Response)->redirect("/notfound.html");
    }
  
            $html =  '<table border="1" cellspacing="0" style="margin: 10% auto; width: 80%; border: 1px solid rgba(0,0,0,.3); font-family: Arial; padding: 20px; background: #f5f4f4;-webkit-box-shadow: 0px 3px 15px 0px rgba(50, 50, 50, 0.3); -moz-box-shadow: 0px 3px 15px 0px rgba(50, 50, 50, 0.3); box-shadow: 0px 5px 15px 0px rgba(50, 50, 50, 0.3);">' . "\n";
        $html .= '<tr><td style="text-align: center; border: none; background: rgba(0,0,0,.03); padding: 7px 15px; font-size: 1.2em; border-radius: 15px;" colspan="3">'
                 . htmlspecialchars($exception->getMessage()) . '</td></tr>';
        $html .= "<tr><td <td style=\"text-align: center; border: none;\" colspan=\"3\">\n<br></td></tr><tr>" . "\n"
               . '<td style="border: none; padding: 10px;" align="center"><b>Функция</b></td>'
                . '<td style="border: none; padding: 10px;" align="center"><b>Расположение</b></td>'
                . '<td style="border: none; padding: 10px;" align="center"><b>Строка</b></td></tr>' . "\n";

        $html .= '<tr style="background: rgba(0,0,0,.03);"><td style="border: none; text-align: center; padding: 7px; border-bottom-left-radius: 15px; border-top-left-radius: 15px;">';
        $html .= $exception->getTrace()[0]['class'].'->'.$exception->getTrace()[0]['function'];
         $html .= '</td><td style="border: none; text-align: center; padding: 7px;">' . $exception->getFile();
        $html .= '</td><td style="border: none; text-align: center; padding: 7px; border-bottom-right-radius: 15px; border-top-right-radius: 15px;">' . $exception->getLine();
        $html .= '</td></tr></table>';
        die($html);
  }

}
?>