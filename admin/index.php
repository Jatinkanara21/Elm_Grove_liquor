<?php
$inventory = [
    [
        'sku' => 'EG-1098',
        'name' => 'Elm Grove Reserve Bourbon',
        'stock' => 42,
        'status' => 'In Stock'
    ],
    [
        'sku' => 'EG-2031',
        'name' => 'Maple Grove Rye',
        'stock' => 18,
        'status' => 'Low Stock'
    ],
    [
        'sku' => 'EG-3320',
        'name' => 'Harvest Gin',
        'stock' => 30,
        'status' => 'In Stock'
    ],
    [
        'sku' => 'EG-4288',
        'name' => 'Orchard Apple Brandy',
        'stock' => 12,
        'status' => 'Low Stock'
    ]
];

$tasks = [
    'Confirm March tasting menu',
    'Prepare newsletter draft',
    'Reorder rye whiskey barrels',
    'Schedule staff training'
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Elm Grove Liquor Admin</title>
  <link rel="stylesheet" href="../assets/styles.css" />
</head>
<body>
  <div class="container">
    <nav class="nav">
      <a href="../index.php">Elm Grove Liquor</a>
      <div class="links">
        <a href="../index.php">View site</a>
        <a href="#inventory">Inventory</a>
        <a href="#tasks">Tasks</a>
      </div>
    </nav>

    <section class="hero">
      <div class="hero-card">
        <span class="badge">Admin Console</span>
        <h1>Welcome back, team.</h1>
        <p>Track inventory, manage events, and keep Elm Grove Liquor operations running smoothly.</p>
        <a class="button" href="#inventory">Review inventory</a>
      </div>
      <div class="hero-card">
        <h2>Quick stats</h2>
        <p><strong>124</strong> bottles in back stock</p>
        <p><strong>5</strong> events scheduled this quarter</p>
        <p><strong>3</strong> staff members on shift today</p>
        <a class="button" href="mailto:ops@elmgroveliquor.com">Message operations</a>
      </div>
    </section>

    <section class="section" id="inventory">
      <h2>Inventory overview</h2>
      <div class="card" style="overflow-x:auto;">
        <table class="table">
          <thead>
            <tr>
              <th>SKU</th>
              <th>Product</th>
              <th>Stock</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($inventory as $item) : ?>
              <tr>
                <td><?php echo htmlspecialchars($item['sku']); ?></td>
                <td><?php echo htmlspecialchars($item['name']); ?></td>
                <td><?php echo htmlspecialchars((string) $item['stock']); ?></td>
                <td><?php echo htmlspecialchars($item['status']); ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </section>

    <section class="section" id="tasks">
      <h2>Team tasks</h2>
      <div class="admin-layout">
        <aside class="sidebar">
          <h3>Next actions</h3>
          <p class="badge">High Priority</p>
          <p>Finalize barrel club shipments by Friday.</p>
          <a class="button" href="mailto:team@elmgroveliquor.com">Send update</a>
        </aside>
        <div class="grid">
          <?php foreach ($tasks as $task) : ?>
            <article class="card">
              <h3><?php echo htmlspecialchars($task); ?></h3>
              <p>Assigned to operations.</p>
            </article>
          <?php endforeach; ?>
        </div>
      </div>
    </section>

    <footer class="footer">
      <p>Elm Grove Liquor Admin · Secure access only.</p>
    </footer>
  </div>
</body>
</html>
