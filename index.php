<?php
	require_once $_SERVER['DOCUMENT_ROOT']."/template/public/inc/header.php";
?>

    <section id="feature_news_section" class="feature_news_section">
        <div class="container">
            <div class="row">
                <?php
					$queryNewest = "SELECT news.id AS newsid ,news.name AS newsname,\n"
								. "news.date_create AS newsdate, COUNT(news_id) AS countcom,\n"
								. "preview, view, picture\n"
								. "FROM news \n"
								. "LEFT JOIN comment ON news.id = comment.news_id\n"
								. "WHERE is_slide = 1 AND news.id = (SELECT MAX(id) FROM news)\n"
								. "GROUP BY newsid\n"
								. "ORDER BY news.id DESC";
					$resultNewest = $mysqli->query($queryNewest);
					if($rowNewest = mysqli_fetch_assoc($resultNewest)){
						$idNewest = $rowNewest['newsid'];
						$pictureNewest = $rowNewest['picture'];
						$nameNewest = $rowNewest['newsname'];
						$motaNewest = $rowNewest['preview'];
						$viewNewest = $rowNewest['view'];
						$commentNewest = $rowNewest['countcom'];
						$dateNewest = date('d-m-Y', strtotime($rowNewest['newsdate']))
				?>
                    <div class="col-md-7">
                        <div class="feature_article_wrapper">
                            <div class="feature_article_img">
                                <img class="newsest top_static_article_img" src="/files/newsIMG/<?php echo $pictureNewest; ?>" alt="feature-top">
                            </div>
                            <!-- feature_article_img -->

                            <div class="feature_article_inner">
                                <div class="tag_lg red"><a href="category.php">Tin mới nhất</a></div>
                                <div class="feature_article_title">
                                    <h1>
                                        <a href="single.php?id=<?php echo $idNewest; ?>" target="_self">
                                            <?php echo $nameNewest; ?> </a>
                                    </h1>
                                </div>
                                <!-- feature_article_title -->

                                <div class="feature_article_date">
                                    <span>
                                        <?php echo $dateNewest; ?>
                                    </span>
                                </div>
                                <!-- feature_article_date -->

                                <div class="feature_article_content">
                                    <?php echo $motaNewest; ?>
                                </div>
                                <!-- feature_article_content -->

                                <div class="article_social">
                                    <span><i class="fa fas fa-eye"></i><a href="#"><?php echo $viewNewest; ?></a>Views</span>
                                    <span><i class="fa fa-comments-o"></i><a href="#"><?php echo $commentNewest; ?></a>Comments</span>
                                </div>
                                <!-- article_social -->

                            </div>
                            <!-- feature_article_inner -->

                        </div>
                        <!-- feature_article_wrapper -->

                    </div>
                    <?php
					}
					?>
                    <!-- col-md-7 -->
                    <?php
						$queryViewest = "SELECT news.id AS newsid ,news.name AS newsname,\n"
									. "news.date_create AS newsdate, COUNT(news_id) AS countcom,\n"
									. "preview, view, picture\n"
									. "FROM news\n"
									. "LEFT JOIN comment ON news.id = comment.news_id\n"
									. "WHERE is_slide = 1 \n"
									. "AND news.id <> (SELECT id FROM news WHERE date_create = (SELECT MAX(date_create) FROM news))\n"
									. "GROUP BY newsid\n"
									. "ORDER BY view DESC\n"
									. "LIMIT 2";
						$resultViewest = $mysqli->query($queryViewest);
						$dem = 0;
						while($rowViewest = mysqli_fetch_assoc($resultViewest)){
							$idViewest = $rowViewest['newsid'];
							$pictureViewest = $rowViewest['picture'];
							$nameViewest = $rowViewest['newsname'];
							$motaViewest = $rowViewest['preview'];
							$viewViewest = $rowViewest['view'];
							$dateViewest = date('d-m-Y', strtotime($rowViewest['newsdate']));
							$commentViewest = $rowViewest['countcom'];
							$dem = $dem + 1;
							if($dem == 1){
					?>
                        <div class="col-md-5">
                            <div class="feature_static_wrapper">
                                <?php
								}else if($dem == 2){
						?>
                                    <div class="col-md-5">
                                        <div class="feature_static_last_wrapper">
                                            <?php
								}
						?>
                                            <div class="feature_article_img">
                                                <img class="viewest" src="/files/newsIMG/<?php echo $pictureViewest; ?>" alt="feature-top">
                                            </div>
                                            <!-- feature_article_img -->

                                            <div class="feature_article_inner">
                                                <div class="tag_lg purple"><a href="category.php">Xem nhiều nhất</a></div>
                                                <div class="feature_article_title">
                                                    <h1>
                                                        <a href="single.php?id=<?php echo $idViewest; ?>" target="_self">
                                                            <?php echo $nameViewest; ?> </a>
                                                    </h1>
                                                </div>
                                                <!-- feature_article_title -->

                                                <div class="feature_article_date"><a href="#" target="_self"></a>
                                                    <span>
                                                        <?php echo $dateViewest; ?>
                                                    </span>
                                                </div>
                                                <!-- feature_article_date -->

                                                <div class="feature_article_content">
                                                    <?php echo $motaViewest; ?>
                                                </div>
                                                <!-- feature_article_content -->

                                                <div class="article_social">
                                                    <span><i class="fa fas fa-eye"></i><a href="#"><?php echo $viewViewest; ?></a>Views</span>
                                                    <span><i class="fa fa-comments-o"></i><a href="#"><?php echo $commentViewest; ?></a>Comments</span>
                                                </div>
                                                <!-- article_social -->

                                            </div>
                                            <!-- feature_article_inner -->

                                        </div>
                                        <!-- feature_static_wrapper -->

                                    </div>
                                    <!-- col-md-5 -->

                                    <?php
							}
						?>
                            </div>
                            <!-- Row -->

                        </div>
                        <!-- container -->

    </section>
    <!-- Feature News Section -->

    <section id="category_section" class="category_section">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
				<?php
				$queryFor = "SELECT id FROM cat_list";
				$resultFor = $mysqli->query($queryFor);
				while($rowFor = mysqli_fetch_assoc($resultFor)){
					$idFor = $rowFor['id'];
					$queryCat = "SELECT news.id AS newsid,cat_list.name AS catname,\n"
							. "news.name AS newsname, news.date_create AS newsdate,\n"
							. "preview, view, picture,\n"
							. "COUNT(news_id) AS countcm\n"
							. "FROM news\n"
							. "INNER JOIN cat_list ON cat_list.id = news.cat_id\n"
							. "LEFT JOIN comment ON news.id = comment.news_id\n"
							. "WHERE cat_id = {$idFor} AND is_slide = 1\n"
							. "GROUP BY news.id\n"
							. "ORDER BY newsid DESC\n"
							. "LIMIT 4";
					$resultCat = $mysqli->query($queryCat);
					$resultCat1 = $mysqli->query($queryCat);
					if($rowCat1 = mysqli_fetch_assoc($resultCat1)){
						$catname = $rowCat1['catname'];
				?>
                    <div class="category_section camera">
                        <div class="article_title header_orange">
                            <h2><a href="category.html" target="_self"><?php echo $catname; ?></a></h2>
                        </div>
                        <!-- article_title -->
					<?php
					while($rowCat2 = mysqli_fetch_assoc($resultCat)){
						$newsid = $rowCat2['newsid'];
						$picture = $rowCat2['picture'];
						$newsname = $rowCat2['newsname'];
						$date_create = date('d-m-Y', strtotime($rowCat2['newsdate']));
						$preview = $rowCat2['preview'];
						$view = $rowCat2['view'];
						$comment = $rowCat2['countcm'];
					?>
                        <div class="category_article_wrapper">
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="top_article_img">
                                        <a href="single.php?id=<?php echo $newsid; ?>" target="_self">
											<img class="catlist" src="/files/newsIMG/<?php echo $picture; ?>" alt="feature-top">
										</a>
                                    </div>
                                    <!-- top_article_img -->

                                </div>
                                <div class="col-md-7">
                                    <span class="tag orange"><?php echo $catname; ?></span>

                                    <div class="category_article_title">
                                        <h2><a href="single.php?id=<?php echo $newsid; ?>" target="_self"><?php echo $newsname; ?> </a></h2>
                                    </div>
                                    <!-- category_article_title -->

                                    <div class="article_date"><span><?php echo $date_create; ?></span></div>
                                    <!----article_date------>
                                    <!-- category_article_wrapper -->

                                    <div class="category_article_content">
                                        <?php echo $preview; ?>
                                    </div>
                                    <!-- category_article_content -->

                                    <div class="media_social">
                                        <span><a href="#"><i class="fa fas fa-eye"></i><?php echo $view; ?> </a> Views</span>
                                        <span><i class="fa fa-comments-o"></i><a href="#"><?php echo $comment; ?></a> Comments</span>
                                    </div>
                                    <!-- media_social -->

                                </div>
                                <!-- col-md-7 -->

                            </div>
                            <!-- row -->

                        </div>
					<?php
						}
					?>
                        <p class="divider"><a href="#">More News&nbsp;&raquo;</a></p>
                    </div>
					<?php
					}
				}
					?>
					
                    <!-- Camera News Section -->
                </div>
                <?php
					require_once $_SERVER['DOCUMENT_ROOT']."/template/public/inc/rightsection.php";
				?>

            </div>
            <!-- Row -->

        </div>
        <!-- Container -->

    </section>
    <!-- Category News Section -->

    <section id="subscribe_section" class="subscribe_section">
        <div class="row">
            <form action="#" method="post" class="form-horizontal">
                <div class="form-group form-group-lg">
                    <label class="col-sm-6 control-label" for="formGroupInputLarge">
                    <h1><span class="red-color">Sign up</span> for the latest news</h1>
                </label>

                    <div class="col-sm-3">
                        <input type="text" id="subscribe" name="subscribe" class="form-control input-lg">
                    </div>
                    <div class="col-sm-1">
                        <input type="submit" value="Sign Up" class="btn btn-large pink">
                    </div>
                    <div class="col-sm-2"></div>
                </div>
            </form>
        </div>
    </section>
    <!-- Subscriber Section -->

    <?php
	require_once $_SERVER['DOCUMENT_ROOT']."/template/public/inc/footer.php";
?>