<!-- Left Section -->

                <div class="col-md-4">
                    <div class="widget">
                        <div class="widget_title widget_black">
                            <h2><a href="#">Popular News</a></h2>
                        </div>
						<?php
							if(empty($_GET['id'])){
								$id = 0;
								$queryPopular = "SELECT news.id AS newsid,cat_list.name AS catname,\n"
										. "news.name AS newsname, news.date_create AS newsdate,\n"
										. "preview, view, picture,\n"
										. "COUNT(news_id) AS countcm\n"
										. "FROM news\n"
										. "INNER JOIN cat_list ON cat_list.id = news.cat_id\n"
										. "LEFT JOIN comment ON news.id = comment.news_id\n"
										. "WHERE is_slide = 1 AND news.id <> (SELECT id FROM news WHERE date_create = (SELECT MAX(date_create) FROM news))\n"
										. "AND news.id <> (SELECT id FROM news WHERE date_create = (SELECT MAX(date_create) FROM news)) \n"
										. "AND (day(news.date_create) BETWEEN day(CURRENT_DATE - 3) AND day(CURRENT_DATE))\n"
										. "AND (month(news.date_create) BETWEEN month(CURRENT_DATE - 3) AND month(CURRENT_DATE))\n"
										. "AND (year(news.date_create) BETWEEN year(CURRENT_DATE - 3) AND year(CURRENT_DATE))\n"
										. "GROUP BY news.id\n"
										. "ORDER BY view DESC\n"
										. "LIMIT 4";
							}else{
								$id = $_GET['id'];
								$queryPopular = "SELECT news.id AS newsid,cat_list.name AS catname,\n"
										. "news.name AS newsname, news.date_create AS newsdate,\n"
										. "preview, view, picture,\n"
										. "COUNT(news_id) AS countcm\n"
										. "FROM news\n"
										. "INNER JOIN cat_list ON cat_list.id = news.cat_id\n"
										. "LEFT JOIN comment ON news.id = comment.news_id\n"
										. "WHERE is_slide = 1 AND news.id <> (SELECT id FROM news WHERE date_create = (SELECT MAX(date_create) FROM news)) AND news.id <> {$id}\n"
										. "AND (day(news.date_create) BETWEEN day(CURRENT_DATE - 3) AND day(CURRENT_DATE))\n"
										. "AND (month(news.date_create) BETWEEN month(CURRENT_DATE - 3) AND month(CURRENT_DATE))\n"
										. "AND (year(news.date_create) BETWEEN year(CURRENT_DATE - 3) AND year(CURRENT_DATE))\n"
										. "GROUP BY news.id\n"
										. "ORDER BY view DESC\n"
										. "LIMIT 4";
							}
							
							$resultPopular = $mysqli->query($queryPopular);
							while($rowPopular = mysqli_fetch_assoc($resultPopular)){
								$idPopular = $rowPopular['newsid'];
								$picturePopular = $rowPopular['picture'];
								$namePopular = $rowPopular['newsname'];
								$motaPopular = $rowPopular['preview'];
								$viewPopular = $rowPopular['view'];
								$commentPopular = $rowPopular['countcm'];
								$datePopular = date('d-m-Y', strtotime($rowPopular['newsdate']));
						?>
                        <div class="media">
                            <div class="media-left">
                                <a href="single.php?id=<?php echo $idPopular; ?>"><img class="popularlist" src="/files/newsIMG/<?php echo $picturePopular; ?>" alt="Generic placeholder image"></a>
                            </div>
                            <div class="media-body">
                                <h3 class="media-heading">
                                    <a href="single.php?id=<?php echo $idPopular; ?>" target="_self"><?php echo $namePopular; ?></a>
                                </h3> <span class="media-date"><a href="#"><?php echo $datePopular; ?></a></span>

                                <div class="widget_article_social">
                                    <span><a href="single.php" target="_self"> <i class="fa fas fa-eye"></i><?php echo $viewPopular; ?></a> Views</span>
                                    <span><a href="single.php" target="_self"><i class="fa fa-comments-o"></i><?php echo $commentPopular; ?></a> Comments</span>
                                </div>
                            </div>
                        </div>
						<?php
							}
						?>
                        <p class="widget_divider"><a href="#" target="_self">More News&nbsp;&raquo;</a></p>
                    </div>
                    <!-- Popular News -->

                    <div class="widget hidden-xs m30">
                        <img class="img-responsive widget_img" src="/template/public/img/right_add5.jpg" alt="add_one">
                    </div>
                    <!-- Advertisement -->

                    <div class="widget hidden-xs m30">
                        <img class="img-responsive widget_img" src="/template/public/img/right_add6.jpg" alt="add_one">
                    </div>
                    <!-- Advertisement -->

                    <div class="widget m30">
                        <div class="widget_title widget_black">
                            <h2><a href="#">Most Commented</a></h2>
                        </div>
						<?php
							if(empty($_GET['id'])){
								$queryMostCm = "SELECT news.id AS newsid, name, news_id,\n"
										. "COUNT(comment.id) AS countcm, picture\n"
										. "FROM news\n"
										. "INNER JOIN comment ON news.id = comment.news_id\n"
										. "WHERE is_slide = 1\n"
										. "GROUP BY news_id\n"
										. "LIMIT 4";
							}
							else{
								$id = $_GET['id'];
								$queryMostCm = "SELECT news.id AS newsid, name, news_id,\n"
										. "COUNT(comment.id) AS countcm, picture\n"
										. "FROM news\n"
										. "INNER JOIN comment ON news.id = comment.news_id\n"
										. "WHERE is_slide = 1 AND news.id <> {$id}\n"
										. "GROUP BY news_id\n"
										. "LIMIT 4";
							}
							$resultMostCm = $mysqli->query($queryMostCm);
							while($rowMostCm = mysqli_fetch_assoc($resultMostCm)){
								$idMostCm = $rowMostCm['newsid'];
								$pictureMostCm = $rowMostCm['picture'];
								$nameMostCm = $rowMostCm['name'];
								$commentMostCm = $rowMostCm['countcm'];
						?>
                        <div class="media">
                            <div class="media-left">
                                <a href="single.php?id=<?php echo $idMostCm; ?>"><img class="popularlist" src="/files/newsIMG/<?php echo $pictureMostCm; ?>" alt="Generic placeholder image"></a>
                            </div>
                            <div class="media-body">
                                <h3 class="media-heading">
                                    <a href="single.php?id=<?php echo $idMostCm; ?>" target="_self"><?php echo $nameMostCm; ?></a>
                                </h3>

                                <div class="media_social">
                                    <span><i class="fa fa-comments-o"></i><a href="#"><?php echo $commentMostCm; ?></a> Comments</span>
                                </div>
                            </div>
                        </div>
						<?php
							}
						?>
                        <p class="widget_divider"><a href="#" target="_self">More News&nbsp;&nbsp;&raquo; </a></p>
                    </div>
                    <!--Advertisement -->

                    <div class="widget hidden-xs m30">
                        <img class="img-responsive widget_img" src="/template/public/img/podcast.jpg" alt="add_one">
                    </div>
                    <!--Advertisement-->
                </div>
                <!-- Right Section -->