<?php
$dsn = 'mysql:dbname=php-book-app;host=localhost;charset=utf8mb4';
$user = 'root';
$password ='';
if (isset($_POST['submit'])) {
  try {
      $pdo = new PDO($dsn, $user, $password);
      $sql_update = '
            UPDATE products
            SET book_code = :book_code,
            pbook_name = :book_name,
            price = :price,
            stock_quantity = :stock_quantity,
            vendor_code = :vendor_code
            WHERE id = :id
        ';
        $stmt_update = $pdo->prepare($sql_update);

$stmt_update->bindValue(':book_code', $_POST['book_code'], PDO::PARAM_INT);
        $stmt_update->bindValue(':book_name', $_POST['book_name'], PDO::PARAM_STR);
        $stmt_update->bindValue(':price', $_POST['price'], PDO::PARAM_INT);
        $stmt_update->bindValue(':stock_quantity', $_POST['stock_quantity'], PDO::PARAM_INT);
        $stmt_update->bindValue(':genre_code', $_POST['genre_code'], PDO::PARAM_INT);
        $stmt_update->bindValue(':id', $_GET['id'], PDO::PARAM_INT);

        $stmt_update->execute();

        $count = $stmt_update->rowCount();

        $message = "商品を{$count}件編集しました。";

        header("Location: read.php?message={$messagr}");
  }catch(PODException $e){
    exit($e->getMessage());
  }
}
if(isset($_GET['id]'])){
try{
  $pdo =new PDO($dsn, $user, $password);

  $sql_select_book = 'SELECT * FROM books WHERE id = :id';

  $stmt_select_book = $pdo->prepare($sql_select_book);

  $stmt_select_book->bindValue(':id',$_GET['id'],PDO::PARAM_INT);

  $stmt_select_book->execute();

  $book = $stmt_select_book->fetch(PDO::FETCH_ASSOC);

  if($book === FALSE){
    exit('IDパラメータの値が不正です。');
  }

  $sql_select_genre_codes = 'SELECT genre_code FROM geners';

  $stmt_select_genre_codes = $pdo->query($sql_select_genre_codes);

  $genre_codes = $stmt_select_genre_codes->fetchAll(PDO::FETCH_COLUMN);
}catch(PDOException $e){
  exit($e->getMessage());
}
}else{
  exit('idパラメータの値が存在しません。');
}
?>



  <!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>書籍登録</title>
    <link rel="stylesheet" href="css/style.css">

    <!--Google Fontsの読み込み -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP&display=swap"rel="stylesheet">
  </head>
  <main>
  <article class="registration">
   <h1>書庫登録</h1>
    <div class="back">
    <a href="read.php" class="btn">&lt;戻る</a>
     </div>
   <form action="create.php" method="post" class="registration-form">
     <div>
       <label for="book_code">書籍コード</label>
       <input type="number" id="book_code" name="book_code" min="0" max="100000000" required>

       <label for="book_name">書庫名</label>
       <input type="text" id="book_name" name="book_name" maxlength="50" required>

       <label for="price">値段</label>
       <input type="number" id="price" name="price" min="0" max="100000000" required>

       <label for="stock_quantity">在庫数</label>
       <input type="number" id="stock_quantity" name="stock_quantity"  min="0" max="100000000" required>

       <label for="genre_code">ジャンルコード</label>
       <select id="genre_code" name="genre_code" required>
         <option disabled selected value>選択してください</option>
         <?php
         foreach ($genre_codes as $genre_code){
          if($genre_codes === $book['genre_code']){
          echo"<option value='{$genrer_code}'>{$genrer_code}</option>";
         }else{
          echo "<option value='{$genre_code}'>{$genre_code}</option>";
         }
        }
         ?>
       </select>
     </div>
      <button type="submit" class="sumit-btn" name="submit" value="update">登録</button>
   </form>
  </article>
</main>
<footer>
 <p class="copyright">&copy;書庫管理アプリAllrghts reserved.</p>
</footer>
</body>
</html>