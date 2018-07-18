<?php
	require_once $_SERVER['DOCUMENT_ROOT']."/template/public/inc/header.php";
?>
<?php
	if(isset($_GET['search'])){
		$search = $_GET['search'];
	}
	$queryTSD = "SELECT COUNT(*) AS TSD FROM news WHERE name LIKE '%{$search}%'";
	$resultTSD = $mysqli->query($queryTSD);
	$arTmp = mysqli_fetch_assoc($resultTSD);
	$tongSoDong = $arTmp['TSD'];
	//số truyện trên 1 trang
	$row_count = ROW_COUNT;
	//Số Trang
	$tongSoTrang = ceil($tongSoDong/$row_count);
	$current_page = 1;
	if(isset($_GET['page'])){
		$current_page = $_GET['page'];
	}
	$offset = ($current_page - 1) * $row_count;
?>
    <section id="category_section" class="category_section">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
				<?php
				if(isset($search)){
					$queryCat = "SELECT news.id AS newsid,cat_list.name AS catname,\n"
							. "news.name AS newsname, news.date_create AS newsdate,\n"
							. "preview, view, picture,\n"
							. "COUNT(news_id) AS countcm\n"
							. "FROM news\n"
							. "INNER JOIN cat_list ON cat_list.id = news.cat_id\n"
							. "LEFT JOIN comment ON news.id = comment.news_id\n"
							. "WHERE is_slide = 1\n"
							. "AND news.name LIKE '%{$search}%'\n"
							. "GROUP BY news.id\n"
							. "ORDER BY newsid DESC\n"
							. "LIMIT {$offset}, {$row_count}";
					$resultCat = $mysqli->query($queryCat);
				?>
                    <div class="category_section camera">
					<?php

					while($rowCat2 = mysqli_fetch_assoc($resultCat)){
						$newsid = $rowCat2['newsid'];
						$picture = $rowCat2['picture'];
						$newsname = $rowCat2['newsname'];
						$date_create = date('d-m-Y', strtotime($rowCat2['newsdate']));
						$preview = $rowCat2['preview']."...";
						$view = $rowCat2['view'];
						$comment = $rowCat2['countcm'];
						$catname = $rowCat2['catname'];
						$urlSeoChiTiet2 = "/chi-tiet/".utf8ToLatin($catname)."/".utf8ToLatin($newsname)."-{$newsid}.html";
					?>
                        <div class="category_article_wrapper">
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="top_article_img">
                                        <a href="<?php echo $urlSeoChiTiet2; ?>" target="_self">
											<img class="catlist" src="/files/newsIMG/<?php echo $picture; ?>" alt="feature-top">
										</a>
                                    </div>
                                    <!-- top_article_img -->

                                </div>
                                <div class="col-md-7">
                                    <span class="tag orange"><?php echo $catname; ?></span>

                                    <div class="category_article_title">
                                        <h2><a href="<?php echo $urlSeoChiTiet2; ?>" target="_self"><?php echo $newsname; ?> </a></h2>
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
                    </div>
					<?php
				}
					?>
					
                    <nav aria-label="Page navigation" class="pagination_section">
						<ul class="pagination">
							<li>
								<a href="#" aria-label="Previous"> <span aria-hidden="true">&laquo;</span> </a>
							</li>
							<?php
								for($i = 1; $i <= $tongSoTrang; $i++){
									$active = '';
									if($i == $current_page){
										$active = 'active';
									}
									//$urlSeoCat = "/tim-kiem/{$i}.html";
									$urlSeoCat = "/tim-kiem/{$search}-{$i}.html";
							?>
							<li class="<?php echo $active; ?>"><a href="<?php echo $urlSeoCat; ?>"><?php echo $i; ?></a></li>
							<?php
								}
							?>
							<li>
								<a href="#" aria-label="Next" class="active"> <span aria-hidden="true">&raquo;</span> </a>
							</li>
						</ul>
					</nav>
					<!-- navigation -->
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