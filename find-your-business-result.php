<?php 
require('includes/db-config.php'); 

// Pagination settings
$results_per_page = 20;
$current_page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$offset = ($current_page - 1) * $results_per_page;


// Prepare search parameters
$business_name = isset($_GET['business_name']) ? trim($_GET['business_name']) : '';

$results = [];
$total_results = 0;
$show_pagination = false;

if (!empty($business_name)) {

    try {
        // Base query
        $count_sql = "SELECT COUNT(*) FROM awards WHERE 1=1";
        $search_sql = "SELECT * FROM awards WHERE 1=1";
        $params = [];

        // Add filters
        if ($business_name) {
            $count_sql .= " AND business_name ILIKE :business_name";
            $search_sql .= " AND business_name ILIKE :business_name";
            $params[':business_name'] = "%$business_name%";
        }

        // Execute count query
        $count_stmt = $pdo->prepare($count_sql);
        foreach ($params as $key => $value) {
            $count_stmt->bindValue($key, $value, is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR);
        }
        $count_stmt->execute();
        $total_results = $count_stmt->fetchColumn();

        // Pagination
        $total_pages = ceil($total_results / $results_per_page);
        $show_pagination = $total_pages > 1;

        // Execute search query with pagination
        $search_sql .= " ORDER BY business_name ASC LIMIT :limit OFFSET :offset";
        $search_stmt = $pdo->prepare($search_sql);
        foreach ($params as $key => $value) {
            $search_stmt->bindValue($key, $value, is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR);
        }
        $search_stmt->bindValue(':limit', $results_per_page, PDO::PARAM_INT);
        $search_stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $search_stmt->execute();
        $results = $search_stmt->fetchAll(PDO::FETCH_ASSOC);

    }catch (PDOException $e) {
      error_log("Search Error: " . $e->getMessage());
      $error = "An error occurred while searching.";
    }
}

// Function to generate pagination URL
function get_pagination_url($page) {
    $params = $_GET;
    $params['page'] = $page;
    return '?' . http_build_query($params);
}

require('includes/header.php'); ?>
<section class="business_finder ">
  <?php if (!empty($results)): ?>
  <div class="container col-md-9">
    <div class="common_title">
      <h2><span>CHOOSE</span> YOUR BUSINESS</h2>
     </div><!--end of common title-->
    <ul class="list-unstyled steps_count">
      <li><span>1</span> <small>Step1</small></li>
      <li class="active"><span>2</span> <small>Step2</small></li>
      <li><span>3</span> <small>Step3</small></li>
  </ul>
    <div class="table-responsive">
      <table class="table table-hover align-middle table-striped">
        <thead class="table-dark">
          <tr>
            <th colspan="2">Business Name</th>
            <th>Category</th>
            <th>City</th>
            <th>Select</th>
          </tr>
        </thead>
        <tbody>
        <?php foreach ($results as $result): ?>
          <tr>
            <td class="pe-0"><img src="images/2024.png" alt=""></td>
            <td class="ps-0"><?php echo htmlspecialchars($result['business_name']); ?></td>
            <td><?php echo htmlspecialchars($result['category']); ?></td>
            <td><?php echo htmlspecialchars($result['city'] . ', ' . $result['state']); ?></td>
            <?php ?>
            <td><a href="/payment-step?business_name=<?php echo htmlspecialchars($result['business_name']); ?>&ID=<?php echo htmlspecialchars($result['id']); ?>&category=<?php echo htmlspecialchars($result['category']); ?>&state=<?php echo htmlspecialchars($result['state']); ?>&type=<?php echo $_GET['type']; ?>#form" class="btn">Select</a></td>
          </tr>
         <?php endforeach; ?>
        </tbody>
      </table>
    </div><!--end of table responsive-->
  </div><!--end of container-->
  <?php if ($show_pagination): ?>
  <div class="pagination">
    <?php if ($current_page > 1): ?>
    <a href="<?php echo get_pagination_url($current_page - 1); ?>">Previous</a>
    <?php endif; ?>

    <?php for ($i = 1; i <= $total_pages; $i++): ?>
    <a href="<?php echo get_pagination_url($i); ?>" 
    class="<?php echo ($current_page === $i) ? 'active' : ''; ?>">
    <?php echo $i; ?>
    </a>
    <?php endfor; ?>

    <?php if ($current_page < $total_pages): ?>
    <a href="<?php echo get_pagination_url($current_page + 1); ?>">Next</a>
    <?php endif; ?>
  </div>
  <?php endif; ?>
  <?php elseif (isset($_GET['business_name'])): ?>
    <div class="titlec1" style="padding:100px 0px;">
      <h3 class="titleh2" style="text-align:center">
      Sorry we couldn't locate your business.<br>Want to try searching again?<br>Try using different spelling
      </h3>
    <br>
    <a href="javascript:history.back()" class="b_form_home edit_search">
      <i style="color:#fff" aria-hidden="true" class="fas fa-search"></i> SEARCH AGAIN
    </a>
    <br><br>
    <h1 style="font-size:3.5rem;color:#E73438;">OR</h1>

    <h3>Proceed any way and we will find your business for you.</h3>
    <br>
    <a class="b_form_home edit_search" href="/payment-step?business_ID=0&amp;type=1#form">
      <i aria-hidden="true" class="fas fa fa-arrow-circle-right"></i> CONTINUE TO NEXT STEP
    </a>
    </div>
  <?php endif; ?>
</section>
<?php require('includes/footer.php'); ?>