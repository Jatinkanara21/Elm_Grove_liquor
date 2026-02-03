<?php
$featured = [
    [
        'name' => 'Elm Grove Reserve Bourbon',
        'notes' => 'Small-batch bourbon with notes of vanilla, toasted oak, and honeycomb.'
    ],
    [
        'name' => 'Maple Grove Rye',
        'notes' => 'Spiced rye whiskey finished with maple and clove.'
    ],
    [
        'name' => 'Harvest Gin',
        'notes' => 'Botanical gin with juniper, citrus peel, and rosemary.'
    ],
    [
        'name' => 'Orchard Apple Brandy',
        'notes' => 'Aromatic apple brandy aged in American oak.'
    ]
];

$events = [
    [
        'title' => 'Tasting Flight Fridays',
        'date' => 'Every Friday · 4 PM - 7 PM'
    ],
    [
        'title' => 'Distiller Q&A',
        'date' => 'Mar 12 · 6 PM'
    ],
    [
        'title' => 'Barrel Club Pick-up',
        'date' => 'Apr 3 · 2 PM'
    ]
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Elm Grove Liquor</title>
  <link rel="stylesheet" href="assets/styles.css" />
</head>
<body>
  <div class="container">
    <nav class="nav">
      <a href="index.php">Elm Grove Liquor</a>
      <div class="links">
        <a href="#catalog">Catalog</a>
        <a href="#events">Events</a>
        <a href="#visit">Visit</a>
        <a href="admin/index.php">Admin</a>
      </div>
    </nav>

    <section class="hero">
      <div>
        <div class="hero-card">
          <span class="badge">Since 1987 · Family Owned</span>
          <h1>Craft spirits curated with Elm Grove hospitality.</h1>
          <p>Discover hand-selected bottles, tasting flights, and seasonal releases from Wisconsin's favorite neighborhood liquor shop.</p>
          <a class="button" href="#catalog">Explore the selection</a>
        </div>
      </div>
      <div>
        <div class="hero-card">
          <h2>Store hours</h2>
          <p>Monday - Thursday: 10 AM - 8 PM<br />Friday - Saturday: 10 AM - 10 PM<br />Sunday: 11 AM - 6 PM</p>
          <p>242 Elm Grove Avenue<br />Elm Grove, WI 53122</p>
          <a class="button" href="#visit">Plan your visit</a>
        </div>
      </div>
    </section>

    <section class="section" id="catalog">
      <h2>Featured bottles</h2>
      <div class="grid">
        <?php foreach ($featured as $item) : ?>
          <article class="card">
            <h3><?php echo htmlspecialchars($item['name']); ?></h3>
            <p><?php echo htmlspecialchars($item['notes']); ?></p>
          </article>
        <?php endforeach; ?>
      </div>
    </section>

    <section class="section" id="events">
      <div class="banner">
        <div>
          <h2>Upcoming tastings & events</h2>
          <p>Join our team for guided tastings, pairing nights, and distiller meet-and-greets.</p>
        </div>
        <a class="button" href="mailto:events@elmgroveliquor.com">Reserve a spot</a>
      </div>
      <div class="grid" style="margin-top: 24px;">
        <?php foreach ($events as $event) : ?>
          <article class="card">
            <h3><?php echo htmlspecialchars($event['title']); ?></h3>
            <p><?php echo htmlspecialchars($event['date']); ?></p>
          </article>
        <?php endforeach; ?>
      </div>
    </section>

    <section class="section" id="visit">
      <div class="grid">
        <article class="card">
          <h3>Neighborhood concierge</h3>
          <p>Ask our staff for pairing recommendations, gift baskets, and local distillery highlights.</p>
        </article>
        <article class="card">
          <h3>Local delivery</h3>
          <p>Same-day delivery available within Elm Grove and surrounding neighborhoods.</p>
        </article>
        <article class="card">
          <h3>Barrel club</h3>
          <p>Members receive exclusive barrel picks, early access, and tasting invitations.</p>
        </article>
      </div>
    </section>

    <footer class="footer">
      <p>Elm Grove Liquor · Crafted spirits, curated moments.</p>
    </footer>
  </div>
</body>
</html>
