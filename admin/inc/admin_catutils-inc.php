<?php

function PrintWorkCatalog($parentid, $langid, $level, $mode = "", $selid = 0, $makeid = 0, $hidden = false)
{
	global $THIS_TABLE, $THIS_TABLE_LANG, $THIS_TABLE_P2P, $PHP_SELF,
		$TABLE_CAT_ITEMS, $TABLE_CAT_MAKE, $TABLE_CAT_MAKE_LANGS, $TABLE_CAT_ITEMS_LANGS, $TABLE_CAT_PRICES,
		$TABLE_FAQ_ASSIGN, $TABLE_CAT_CATITEMS;

	$fulltxt = "";

	$query = "SELECT s1.*, s2.name, s2.descr
		FROM $THIS_TABLE s1, $THIS_TABLE_LANG s2
		WHERE s1.parent_id='$parentid' AND s1.id=s2.sect_id AND s2.lang_id='$langid'
		ORDER BY s1.sort_num";

	if( $res = mysqli_query($upd_link_db, $query ) )
	{
		while( $row = mysqli_fetch_object($res) )
		{
			$combotxt = "";

			//echo "Item: ".$row->id.":".$row->parent_id."<br />";
			if( $mode == "select" )
			{
				echo "<option value=\"".$row->id."\"".($selid == $row->id ? " selected " : "" ).">";
				for($i=0; $i<$level; $i++)
				{
			    	echo "&nbsp;&nbsp;&nbsp;";
			    }
			}
			else if( $mode == "fulllist" )
			{
			    	//echo "<option value=\"0\">";
			    	//echo "--";
				for($i=0; $i<$level; $i++)
				{
			    	//echo "--";
			    }
			    //echo "&gt; ";
			}
			else if( $mode == "work" )
			{
				//if( $level == 0 )
				//{
				echo "<tr>";
				//}

				echo "<td>";
			}
			else if( $mode == "checklist" )
			{
				$ischecked = false;
				$query1 = "SELECT * FROM $THIS_TABLE_P2P WHERE item_id='$selid' AND sect_id='".$row->id."'";
				if( $res1 = mysqli_query($upd_link_db, $query1 ) )
				{
					while( $row1 = mysqli_fetch_object( $res1 ) )
				    {
				    	$ischecked = true;
				    }
				    mysqli_free_result( $res1 );
				}
				echo "<tr><td class=\"fr\" style=\"padding: 1px 10px 1px ".(20*$level)."px\"><input type=\"checkbox\" name=\"sectids[]\" value=\"".$row->id."\" ".($ischecked ? " checked " : "")." />";
			}
			else if( $mode == "checklistall" )
			{
               	//$ischecked = false;
               	//$query1 = "SELECT * FROM $THIS_TABLE_P2P WHERE item_id='$selid' AND sect_id='".$row->id."'";
                //if( $res1 = mysqli_query($upd_link_db, $query1 ) )
                //{
                //	while( $row1 = mysqli_fetch_object( $res1 ) )
                //    {
                //    	$ischecked = true;
                //    }
                //    mysqli_free_result( $res1 );
                //}
               	//echo "<tr><td class=\"fr\" style=\"padding: 1px 10px 1px ".(20*$level)."px\"><input type=\"checkbox\" name=\"sectids[]\" value=\"".$row->id."\" ".($ischecked ? " checked " : "")." />";

				echo "<tr><td class=\"fr\" style=\"padding: 1px 10px 1px ".(20*$level)."px\">";
			}
			else if( $mode == "indexlist" )
			{
				// Calculate number of subsections in this section
				$subitems = 0;
				$query1 = "SELECT count(*) as totsubitems
					FROM $THIS_TABLE s1, $THIS_TABLE_LANG s2
					WHERE s1.parent_id='".$row->id."' AND s1.id=s2.sect_id AND s2.lang_id='$langid'";
				if( $res1 = mysqli_query($upd_link_db, $query1 ) )
				{
					while( $row1 = mysqli_fetch_object( $res1 ) )
					{
						$subitems = $row1->totsubitems;
					}
					mysqli_free_result( $res1 );
				}

				if( $level == 0 )
				{
					echo '<table cellspacing="3" cellpadding="0" border="0" width="236">';
					echo '<tr><td style="padding: 1px 0px 1px '.($level*20+5).'px;">
					<table border="0" cellspacing="0" cellpadding="0">
					<tr>';
					echo '<td width="16"><img src="img/bluearr_d.gif" width="9" height="5" alt="" /></td>';

					if( $subitems > 0 )
						echo '<td><a href="javascript:voidfn(0)" name="alink'.$row->id.'" class="blue8link" onclick="javascript:ToggleNotes(\'catpan'.$row->id.'\', \'\');">';
					else
						echo '<td><a href="catalog.php?sid='.$row->id.'" class="blue8link">';

					echo stripslashes($row->name);

					echo '</a></td>
					</tr>
					<tr><td colspan="2" style="padding: 4px 0px 3px 0px;"><span id="catpan'.$row->id.'" name="catpan'.$row->id.'" style="margin: 0px 0px 0px 0px; padding: 0px 0px 0px 0px; visibility:hidden; display: none;">';
				}
				else
				{
					echo '<div style="padding: 1px 0px 1px '.($level*20+5).'px; margin: 0px 0px 0px 0px;">
					<table border="0" cellspacing="0" cellpadding="0">
					<tr>';
					if( $subitems > 0 )
					{
						echo '<td width="16"><img src="img/bluearr_d.gif" width="9" height="5" alt="" /></td>
						<td><a href="catalog.php?sid='.$row->id.'" class="blue8link">'.stripslashes($row->name).'</td>';
					}
					else
					{
						echo '<td width="10"><img src="img/bluearr_r.gif" width="4" height="7" alt="" /></td>
						<td><a href="catalog.php?sid='.$row->id.'" class="blue8link">'.stripslashes($row->name).'</td>';
					}
					echo '</tr>
					</table>
					</div>';
				}
			}
			else if ( $mode == "prices" )
			{
				$itemsnum = 0;
				$query1 = "SELECT count(*) as totprod FROM $THIS_TABLE_P2P WHERE sect_id='".$row->id."'";
				if( $res1 = mysqli_query($upd_link_db, $query1 ) )
				{
					while( $row1 = mysqli_fetch_object( $res1 ) )
				    {
				    	$itemsnum = $row1->totprod;
				    }
				    mysqli_free_result( $res1 );
				}
				echo "<tr><td></td><td style=\"font-weight: bold; padding: 1px 10px 1px ".(20*$level)."px\">";
			}
			else if ($mode == "pricelist")
			{
				echo "<tr><td colspan=\"3\" class=\"pr1\" style=\"padding: 1px 10px 1px ".(5*$level)."px\"><h4>";
			}
			else
			{
				$itemsnum = 0;
				$query1 = "SELECT count(*) as totprod FROM $THIS_TABLE_P2P WHERE sect_id='".$row->id."'";
				if( $res1 = mysqli_query($upd_link_db, $query1 ) )
				{
					while( $row1 = mysqli_fetch_object( $res1 ) )
				    {
				    	$itemsnum = $row1->totprod;
				    }
				    mysqli_free_result( $res1 );
				}
				echo "<tr><td style=\"padding: 1px 10px 1px ".(20*$level)."px\">";
			}

			if( $mode != "indexlist" )
			{
				if( $mode == "fulllist" )
				{
					//echo ( $level == 0 ? stripslashes($row->name) : stripslashes($row->name) );
				}
				else
				{
					if( ($row->visible == 0) || $hidden )
					{
						echo '<span style="color: #808080;">';
					}

					if($level==0)
					{
						echo "<strong>".$row->sort_num.". ".stripslashes($row->name)."</strong>";
					}
					else
					{
						echo "".$row->sort_num.". ".stripslashes($row->name);
					}

					if( ($row->visible == 0) || $hidden )
					{
						echo '</span>';
					}
				}
			}

			if( $mode == "select" )
			{
				echo "</option>";
			}
			else if( $mode == "fulllist" )
			{
				//echo "</option>";
				$txtprod = "";

				if( $makeid == 0 )
				{
					$query1 = "SELECT i1.id, i2.descr, p1.id as assign_id, i1.model, ml1.make_name
						FROM $THIS_TABLE_P2P p1
						INNER JOIN $TABLE_CAT_ITEMS i1 ON p1.item_id=i1.id
						INNER JOIN $TABLE_CAT_ITEMS_LANGS i2 ON i2.item_id=i1.id AND i2.lang_id='$langid'
						INNER JOIN $TABLE_CAT_MAKE m1 ON i1.make_id=m1.id
						INNER JOIN $TABLE_CAT_MAKE_LANGS ml1 ON m1.id=ml1.make_id AND ml1.lang_id='$langid'
						WHERE p1.sect_id='".$row->id."'
						ORDER BY ml1.make_name, i1.model";
				}
				else
				{
					$query1 = "SELECT i1.id, i2.descr, p1.id as assign_id, i1.model, ml1.make_name
						FROM $THIS_TABLE_P2P p1
						INNER JOIN $TABLE_CAT_ITEMS i1 ON p1.item_id=i1.id
						INNER JOIN $TABLE_CAT_ITEMS_LANGS i2 ON i2.item_id=i1.id AND i2.lang_id='$langid'
						INNER JOIN $TABLE_CAT_MAKE m1 ON i1.make_id=m1.id
						INNER JOIN $TABLE_CAT_MAKE_LANGS ml1 ON m1.id=ml1.make_id AND ml1.lang_id='$langid'
						WHERE p1.sect_id='".$row->id."' AND i1.make_id='$makeid'
						ORDER BY ml1.make_name, i1.model";
				}
				if( $res1 = mysqli_query($upd_link_db, $query1 ) )
				{
					while( $row1 = mysqli_fetch_object( $res1 ) )
					{
						// Now we should find the price and availiablity for this item
						//echo "<option value=\"".$row1->id."\"".($selid == $row1->id ? " selected " : "").">";
						$txtprod .= "<option value=\"".$row1->id."\"".($selid == $row1->id ? " selected " : "").">";
						for($i=0; $i<=$level; $i++)
						{
							//echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
						}

						//echo "&nbsp;&nbsp;&nbsp;";
						$txtprod .= "&nbsp;&nbsp;&nbsp;";

						if( $makeid == 0 )
							//echo stripslashes($row1->make_name)." ";
							$txtprod .= stripslashes($row1->make_name)." ";

						//echo stripslashes($row1->model);
						$txtprod .= stripslashes($row1->model)." ";
						//echo "</option>";
						$txtprod .= "</option>";
					}
					mysqli_free_result( $res1 );
				}
				else
					echo mysqli_error();

				if( $txtprod != "" )
				{
					$combotxt .= "<option value=\"0\">".stripslashes($row->name)."</option>";
					$combotxt .= $txtprod;
				}
			}
			else if( $mode == "work" )
			{
				echo "</td><td></td><td></td></tr>";

				//PrintWorks($row->id, $langid);
			}
			else if( $mode == "checklist" )
			{
				echo "</td><td class=\"fr\"> &nbsp; </td></tr>";
			}
			else if ( $mode == "indexlist" )
			{
				if( $level == 0 )
				{
					//echo '</span></td></tr>
					//</table>';
				}
				else
				{
					//echo '</a></td>
					//</tr>
					//</table>
					//</td></tr>';
				}
			}
			else if ( ($mode == "prices") || ($mode == "pricelist") )
			{
				if( $mode == "prices" )
					echo " ($itemsnum)</td><td>
					<a href=\"$PHP_SELF?item_id=".$row->id."&action=list\"><img src=\"img/find.gif\" width=\"20\" height=\"20\" border=\"0\" alt=\"Посмотреть товары\" /></a>&nbsp;
					</td><td></td></tr>";
				else
					echo "</h4></td></tr>";

				if( ($row->id == $selid) || ($mode == "pricelist") )
				{
					$query1 = "SELECT i1.id, i2.descr, p1.id as assign_id, i1.model, ml1.make_name
						FROM $THIS_TABLE_P2P p1
						INNER JOIN $TABLE_CAT_ITEMS i1 ON p1.item_id=i1.id
						INNER JOIN $TABLE_CAT_ITEMS_LANGS i2 ON i2.item_id=i1.id AND i2.lang_id='$langid'
						INNER JOIN $TABLE_CAT_MAKE m1 ON i1.make_id=m1.id
						INNER JOIN $TABLE_CAT_MAKE_LANGS ml1 ON m1.id=ml1.make_id AND ml1.lang_id='$langid'
						WHERE p1.sect_id='".$row->id."'
						ORDER BY ml1.make_name, i1.model";
					if( $res1 = mysqli_query($upd_link_db, $query1 ) )
					{
						while( $row1 = mysqli_fetch_object( $res1 ) )
						{
							// Now we should find the price and availiablity for this item
							$thiscost = "0.00";
							$isexist = false;
							$query2 = "SELECT * FROM $TABLE_CAT_PRICES WHERE item_id='".$row1->id."'";
							if( $res2 = mysqli_query($upd_link_db, $query2 ) )
							{
								while( $row2 = mysqli_fetch_object( $res2 ) )
								{
									$thiscost = $row2->price;
									//$isexist = true;
									$isexist = ( $row2->availiable_now == 1 );
								}
								mysqli_free_result( $res2 );
							}

							if( $mode == "prices" )
							{
								// Print row with item
								echo "<tr>
								<td><input type=\"checkbox\" name=\"prodids".$row1->id."\" value=\"".$row1->id."\" ".($isexist ? " checked " : "")." /></td>
       							<td style=\"padding: 1px 10px 1px ".(20*$level + 20)."px\">".stripslashes($row1->make_name)." ".stripslashes($row1->model)."</td>
       							<td></td>
       							<td>
									<input type=\"hidden\" name=\"prids[]\" value=\"".$row1->id."\" />
									<input type=\"text\" name=\"prvals[]\" style=\"text-align: right; width: 60px;\" value=\"".($thiscost)."\" />
								</td>
								</tr>";
							}
							else
							{
								$descr = strip_tags(stripslashes($row1->descr));
								if( strlen($descr) > 50 )
								{
									$descr = substr($descr, 0, 50)."...";
								}
								echo "<tr><td class=\"pr1\"><a href=\"product.php?sid=".$row->id."&pid=".$row1->id."\" class=\"blue8link\">".stripslashes($row1->make_name)." ".stripslashes($row1->model)."</a> <span class=\"detail\">(".$descr.")</span></td>
								<td class=\"pr2\">".( $thiscost == 0 ? " - " : $thiscost)."</td>
								<td class=\"pr2\">".($isexist ? "склад" : "<span style=\"color: #BBBBBB;\">заказ</span>")."</td>
								</tr>";
							}
						}
						mysqli_free_result( $res1 );
					}
					else
						echo mysqli_error();
				}
			}
			else if( $mode == "checklistall" )
			{
				echo "</td></tr>";

				$query1 = "SELECT i1.id, i1.profile_id, p1.id as assign_id, i1.model, i1.make_id, ml1.make_name
					FROM $THIS_TABLE_P2P p1
					INNER JOIN $TABLE_CAT_ITEMS i1 ON p1.item_id=i1.id
					INNER JOIN $TABLE_CAT_MAKE m1 ON i1.make_id=m1.id
					INNER JOIN $TABLE_CAT_MAKE_LANGS ml1 ON m1.id=ml1.make_id AND ml1.lang_id='$langid'
					WHERE p1.sect_id='".$row->id."'";
				if( $res1 = mysqli_query($upd_link_db, $query1 ) )
				{
					while( $row1 = mysqli_fetch_object( $res1 ) )
					{
						$ischecked = false;
						$query2 = "SELECT * FROM $TABLE_FAQ_ASSIGN WHERE faq_id='$selid' AND item_id='".$row1->id."'";
				        if( $res2 = mysqli_query($upd_link_db, $query2 ) )
				        {
				            while( $row2 = mysqli_fetch_object( $res2 ) )
				            {
				            	$ischecked = true;
				            }
				            mysqli_free_result( $res2 );
				        }

				        echo "<tr>
				        <td class=\"fr\" style=\"padding: 1px 10px 1px ".(20*$level + 20)."px\">
				        	<input type=\"checkbox\" name=\"prodids[]\" value=\"".$row1->id."\" ".($ischecked ? " checked " : "")." />".stripslashes($row1->make_name)." ".stripslashes($row1->model)."</td>
				        </tr>";
					}
					mysqli_free_result( $res1 );
				}
				else
					echo mysqli_error();
			}
			else if( $mode == "fortitles" )
			{
				echo " ($itemsnum)</td><td>
				<a href=\"$PHP_SELF?item_id=".$row->id."&mode=edit\"><img src=\"img/edit.gif\" width=\"20\" height=\"20\" border=\"0\" alt=\"Редактировать\" /></a>&nbsp;
				</td></tr>";

				// Show this section with make filters
				$selmakes = Array();
				$query1 = "SELECT DISTINCT m1.id, m1.url as urlmake, m2.make_name
					FROM $TABLE_CAT_CATITEMS c1
					INNER JOIN $TABLE_CAT_ITEMS i1 ON c1.item_id=i1.id
					INNER JOIN $TABLE_CAT_MAKE m1 ON i1.make_id=m1.id
					INNER JOIN $TABLE_CAT_MAKE_LANGS m2 ON m1.id=m2.make_id AND m2.lang_id=$langid
					WHERE c1.sect_id=".$row->id."
					ORDER BY m2.make_name";
				if( $res1 = mysqli_query($upd_link_db, $query1 ) )
				{
					while( $row1 = mysqli_fetch_object( $res1 ) )
					{
						$mi = Array();
						$mi['id'] = $row1->id;
						$mi['url'] = stripslashes($row1->urlmake);
						$mi['name'] = stripslashes($row1->make_name);

						$selmakes[] = $mi;
					}
					mysqli_free_result( $res1 );
				}
				else
					echo mysqli_error();

				for( $k=0; $k<count($selmakes); $k++ )
				{
					echo '<tr><td style="padding: 1px 10px 1px '.(20*$level + 20).'px">'.$selmakes[$k]['name'].'</td>
					<td><a href="'.$PHP_SELF.'?item_id='.$row->id.'&make_id='.$selmakes[$k]['id'].'&mode=edit" title="Редактировать &quot;'.$selmakes[$k]['name'].'&quot;"><img src="img/edit.gif" width="20" height="20" border="0" alt="Редактировать &quot;'.$selmakes[$k]['name'].'&quot;" /></a></td>
					</tr>';
				}
			}
			else
			{
				echo " ($itemsnum)</td><td>
					<a onclick='return confirm(\"При удаление вся информация связанная с разделом &lt;".stripslashes($row->name)."&gt; будет удалена.\\r\\nУдалить ".$row->name."?\")' href=\"$PHP_SELF?action=deleteitem&item_id=".$row->id."\"><img src=\"img/delete.gif\" width=\"20\" height=\"20\" border=\"0\" alt=\"Удалить\" /></a>&nbsp;
					<a href=\"$PHP_SELF?item_id=".$row->id."&mode=edit\"><img src=\"img/edit.gif\" width=\"20\" height=\"20\" border=\"0\" alt=\"Редактировать\" /></a>&nbsp;
					<a href=\"$PHP_SELF?item_id=".$row->id."&action=list\"><img src=\"img/find.gif\" width=\"20\" height=\"20\" border=\"0\" alt=\"Посмотреть товары\" /></a>&nbsp;
				</td></tr>";

				if( ($mode == "products") && ($row->id == $selid) )
				{
					$query1 = "SELECT i1.id, i1.profile_id, p1.id as assign_id, i1.model, i1.make_id, ml1.make_name
						FROM $THIS_TABLE_P2P p1
						INNER JOIN $TABLE_CAT_ITEMS i1 ON p1.item_id=i1.id
						INNER JOIN $TABLE_CAT_MAKE m1 ON i1.make_id=m1.id
						INNER JOIN $TABLE_CAT_MAKE_LANGS ml1 ON m1.id=ml1.make_id AND ml1.lang_id='$langid'
						WHERE p1.sect_id='".$row->id."'";
					if( $res1 = mysqli_query($upd_link_db, $query1 ) )
					{
						while( $row1 = mysqli_fetch_object( $res1 ) )
						{
							echo "<tr><td style=\"padding: 1px 10px 1px ".(20*$level + 20)."px\">
								<input type=\"checkbox\" name=\"prodids[]\" value=\"".$row1->assign_id."\" />
								".stripslashes($row1->make_name)." ".stripslashes($row1->model)."</td>
							<td>
								&nbsp;<a href=\"cat_best.php?item_id=".$row1->id."&action=addto\"><img src=\"img/page1.gif\" width=\"16\" height=\"20\" border=\"0\" alt=\"На первую страницу\" /></a>&nbsp;";
								//echo "<a href=\"cat_itemdoc.php?newitemid=".$row1->id."\"><img src=\"img/word.gif\" width=\"20\" height=\"20\" border=\"0\" alt=\"Файлы документации\" /></a>&nbsp;";
								//echo "<a href=\"cat_itemapp.php?newitemid=".$row1->id."\"><img src=\"img/application.gif\" width=\"20\" height=\"20\" border=\"0\" alt=\"Приложения и прошивки\" /></a>&nbsp;";
							echo "<a href=\"cat_addprod.php?item_id=".$row1->id."&action=edititem&car_make=".$row1->make_id."&catid=".$row1->profile_id."\"><img src=\"img/edit.gif\" width=\"20\" height=\"20\" border=\"0\" alt=\"Редактировать\" /></a>&nbsp;
							</td>
							</tr>";
						}
						mysqli_free_result( $res1 );
					}
					else
						echo mysqli_error();
               	}
			}

			$txtret = PrintWorkCatalog($row->id, $langid, $level+1, $mode, $selid, $makeid, (($row->visible == 0) || $hidden) );
			if( $txtret != "" )
			{
				if( $combotxt == "" )
				{
					$combotxt .= "<option value=\"0\">".stripslashes($row->name)."</option>";
				}
				$combotxt .= $txtret;
			}

			if( ($mode == "indexlist") && ($level == 0) )
			{
				echo '</span></td></tr></table>
				</td></tr></table>';
				echo '<img src="img/dots_right.gif" width="235" height="1" alt="" />';
       			//echo '<table cellspacing="3" cellpadding="0" border="0" width="236">';
			}

			$fulltxt .= $combotxt;
		}
		mysqli_free_result($res);
	}
	else
		echo mysqli_error();

	return $fulltxt;
}

?>
