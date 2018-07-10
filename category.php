<?php
	require_once $_SERVER['DOCUMENT_ROOT']."/template/public/inc/header.php";
?>

                <div class="container">
                    <div class="row">
                        <div class="col-md-8">
						<?php
							$id = $_GET['id'];	
							if(empty($id)){
								header('location: index.php');
							}
							$queryNewest = "SELECT news.id AS newsid ,news.name AS newsname,\n"
										. "news.date_create AS newsdate, COUNT(news_id) AS countcom,\n"
										. "preview, view, picture, cat_id, cat_list.name AS catname\n"
										. "FROM news\n"
										. "LEFT JOIN comment ON news.id = comment.news_id\n"
										. "INNER JOIN cat_list ON news.cat_id = cat_list.id\n"
										. "WHERE is_slide = 1 AND cat_list.status = 1 AND cat_id = {$id} \n"
										. "OR cat_list.parent_id = {$id} AND is_slide = 1\n"
										. "GROUP BY newsid\n"
										. "ORDER BY news.id DESC";
							$resultNewest = $mysqli->query($queryNewest);
							
							$queryCat1 = "SELECT name, id FROM cat_list WHERE id = {$id}";
							$resultCat1 = $mysqli->query($queryCat1);
							if($rowCat1 = mysqli_fetch_assoc($resultCat1)){
								$catname1 = $rowCat1['name'];
								$catid1 = $rowCat1['id'];
							}
							if($rowNewest = mysqli_fetch_assoc($resultNewest)){
								$idNewest = $rowNewest['newsid'];
								$pictureNewest = $rowNewest['picture'];
								$nameNewest = $rowNewest['newsname'];
								$catnameNewest = $rowNewest['catname'];
								$motaNewest = $rowNewest['preview']."...";
								$viewNewest = $rowNewest['view'];
								$commentNewest = $rowNewest['countcom'];
								$dateNewest = date('d-m-Y', strtotime($rowNewest['newsdate']))
						?>
                            <div class="entity_wrapper">
                                <div class="entity_title header_purple">
                                    <h1><a href="category.php" target="_blank"><?php echo $catname1; ?></a></h1>
                                </div>
                                <!-- entity_title -->

                                <div class="entity_thumb">
                                    <a href="single.php?id=<?php echo $idNewest; ?>"><img class="catimg" src="/files/newsIMG/<?php echo $pictureNewest; ?>" alt="feature-top" ></a>
                                </div>
                                <!-- entity_thumb -->

                                <div class="entity_title">
                                    <a href="single.php?id=<?php echo $idNewest; ?>">
                                        <h2> <?php echo $nameNewest; ?> </h2>
                                    </a>
                                </div>
                                <!-- entity_title -->

                                <div class="entity_meta">
                                    <a href="#"><?php echo $dateNewest; ?></a>
                                </div>
                                <!-- entity_meta -->

                                <div class="entity_content">
                                    <?php echo $motaNewest; ?>
                                </div>
                                <!-- entity_content -->

                                <div class="entity_social">
                                    <span><i class="fa fas fa-eye"></i><?php echo $viewNewest; ?> <a href="#">Views</a> </span>
                                    <span><i class="fa fa-comments-o"></i><?php echo $commentNewest; ?> <a href="#">Comments</a> </span>
                                </div>
                                <!-- entity_social -->

                            </div>
                            <!-- entity_wrapper -->
						<?php
							}
						?>
						<?php
						$queryCat = "SELECT news.id AS newsid ,news.name AS newsname,\n"
									. "news.date_create AS newsdate, COUNT(news_id) AS countcom,\n"
									. "preview, view, picture, cat_id\n"
									. "FROM news\n"
									. "LEFT JOIN comment ON news.id = comment.news_id\n"
									. "INNER JOIN cat_list ON news.cat_id = cat_list.id\n"
									. "WHERE is_slide = 1 \n"
									. "AND news.id <> (SELECT MAX(news.id) \n"
									. "                FROM news \n"
									. "                INNER JOIN cat_list ON news.cat_id = cat_list.id \n"
									. "                WHERE cat_id = {$id} AND news.is_slide = 1 OR cat_list.parent_id = {$id} AND news.is_slide = 1)\n"
									. "AND cat_id = {$id} \n"
									. "OR cat_list.parent_id = {$id} AND is_slide = 1 \n"
									. "AND news.id <> (SELECT MAX(news.id) \n"
									. "                FROM news \n"
									. "                INNER JOIN cat_list ON news.cat_id = cat_list.id \n"
									. "                WHERE cat_id = {$id} AND news.is_slide = 1 OR cat_list.parent_id = {$id} AND news.is_slide = 1)\n"
									. "GROUP BY newsid\n"
									. "ORDER BY news.id DESC";
									$resultCat = $mysqli->query($queryCat);
									$dem = 0;
									while($rowCat = mysqli_fetch_assoc($resultCat)){
										$idCat = $rowCat['newsid'];
										$pictureCat = $rowCat['picture'];
										$nameCat = $rowCat['newsname'];
										$motaCat = $rowCat['preview']."...";
										$viewCat = $rowCat['view'];
										$dateCat = date('d-m-Y', strtotime($rowCat['newsdate']));
										$commentCat = $rowCat['countcom'];
										$dem++;
										if($dem%2 != 0){
							?>
                            <div class="row">
                                <div class="fixcol-md-6">
                                    <div class="category_article_body">
                                        <div class="top_article_img">
                                            <img class="catlistimg" src="/files/newsIMG/<?php echo $pictureCat; ?>" alt="feature-top">
                                        </div>
                                        <!-- top_article_img -->

                                        <div class="category_article_title">
                                            <h6><a href="single.php?id=<?php echo $idCat; ?>"><?php echo $nameCat; ?></a></h6>
                                        </div>
                                        <!-- category_article_title -->

                                        <div class="article_date">
                                            <a href="#"><?php echo $dateCat; ?></a>
                                        </div>
                                        <!-- article_date -->

                                        <div class="">
                                            <span class="fixp"><?php echo $motaCat ?><span>
                                        </div>
                                        <!-- category_article_content -->

                                        <div class="fixviewcomment">
                                            <span><a href="#"><i class="fa fas fa-eye"></i><?php echo $viewCat; ?> </a> Views</span>
                                            <span><i class="fa fa-comments-o"></i><a href="#"><?php echo $commentCat; ?></a> Comments</span>
                                        </div>
                                        <!-- article_social -->

                                    </div>
                                    <!-- category_article_body -->

                                </div>
							<?php
										}else{
							?>
                                <div class="fixcol-md-6">
                                    <div class="category_article_body">
                                        <div class="top_article_img">
                                            <img class="catlistimg" src="/files/newsIMG/<?php echo $pictureCat; ?>" alt="feature-top">
                                        </div>
                                        <!-- top_article_img -->

                                        <div class="category_article_title">
                                            <h6><a href="single.php?id=<?php echo $idCat; ?>"><?php echo $nameCat; ?></a></h6>
                                        </div>
                                        <!-- category_article_title -->

                                        <div class="article_date">
                                            <a href="#"><?php echo $dateCat; ?></a>
                                        </div>
                                        <!-- article_date -->

                                        <div class="">
                                            <span class="fixp"><?php echo $motaCat ?><span>
                                        </div>
                                        <!-- category_article_content -->

                                        <div class="fixviewcomment">
                                            <span><a href="#"><i class="fa fas fa-eye"></i><?php echo $viewCat; ?> </a> Views</span>
                                            <span><i class="fa fa-comments-o"></i><a href="#"><?php echo $commentCat; ?></a> Comments</span>
                                        </div>
                                        <!-- article_social -->

                                    </div>
                                    <!-- category_article_body -->

                                </div>
                                <!-- col-md-6 -->
						
                            </div>
                            <!-- row -->
						<?php
										}
									}
						?>
						<?php
						if($dem%2!=0){
						?>
						</div>
						<?php
						}
						?>
                           <!-- <div class="widget_advertisement">
                                <img class="img-responsive" src="/template/public/img/category_advertisement.jpg" alt="feature-top">
                            </div>-->
                            <!-- widget_advertisement -->

                            <nav aria-label="Page navigation" class="pagination_section">
                                <ul class="pagination">
                                    <li>
                                        <a href="#" aria-label="Previous"> <span aria-hidden="true">&laquo;</span> </a>
                                    </li>
                                    <li><a href="#">1</a></li>
                                    <li><a href="#">2</a></li>
                                    <li><a href="#">3</a></li>
                                    <li><a href="#">4</a></li>
                                    <li><a href="#">5</a></li>
                                    <li>
                                        <a href="#" aria-label="Next" class="active"> <span aria-hidden="true">&raquo;</span> </a>
                                    </li>
                                </ul>
                            </nav>
                            <!-- navigation -->

                        </div>
                        <!-- col-md-8 -->

                        <?php
							require_once $_SERVER['DOCUMENT_ROOT']."/template/public/inc/rightsection.php";
						?>

                    </div>
                    <!-- row -->

                </div>
                <!-- container -->

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