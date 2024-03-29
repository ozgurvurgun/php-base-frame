# PHP Base Frame (v.1.1.0)

>Base Frame Nedir ? Amacı Nedir ?

- Base Frame tamamen MVC mimarisini gerçeklemeyi hedef alan bir PHP çerçevesidir ve sadece bu görevini tutarlı bir şekilde yerine getirir. Direksiyon tamamen geliştiricinin kontrolündedir :)
- Base Frame temel bir yapı sunar. Bu sofistike sistemlere geçerken altta ki paradigmaları ve kodlama yaklaşımlarını anlama noktasında hoş bir bakış açısı sunar.

## İlk Proje
- Kurulum
```bash
git clone https://github.com/ozgurvurgun/php-base-frame.git
```
- Öncelikle ana dizinde ki <code>env.php</code> dosyanında base url tanımlaması yapılmalıdır. Proje klasöründe değişklik yapmadıysanız base url tanımı varsayılan olarak sorun çıkarmayacaktır. Dizini değiştirdiğinizde base url değerini değiştirmeyi unutmayın!

- <code>app/routes</code> dizini altında <code>routes.php</code> dosyasına aşağıda ki routing kodunu ekleyin. Bunun anlamı: Base Url algılanırsa FirstControllerClass sınıfının içinde ki FirstControllerMethod metodunu çalıştır.
- Run metodu üç parametre alır.
  - yol
  - sınıf@metod
  - istek tipi
- İstek tipi varsayılan olarak <code>get</code> olarak tanımlıdır. İhtiyacınıza göre bunu <code>post</code> olarak değiştirebilirsiniz. Örneğin api oluştururken post yöntemini kullanmak sık bir yaklaşımdır.
```php
use \BaseFrame\System\Core\Router;
Router::run('/', 'FirstControllerClass@FirstControllerMethod');
```
- <code>app/controllers</code> dizini altında <code>FirstControllerClass.php</code> dosyasını oluşturun ve aşağıda ki kodu ekleyin.
```php
namespace BaseFrame\App\Controller;
use BaseFrame\System\Core\Controller;

class FirstControllerClass extends Controller
{
    public function FirstControllerMethod()
    {
        $this->view('firstView');
    }
}
```

- <code>app/views</code> dizini altında <code>firstView.php</code> dosyasını oluşturun ve aşağıda ki html kodunu ekleyin.
```html
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>PHP BASE FRAME</title>
  </head>
  <body>
    <h1>Hello World</h1>
  </body>
</html>
```
- Şu ana kadar url'e göre nasıl view çağıracağımızı öğrendik.

## View'a Veri Göndermek
- View çağırılırken view adından sonra ikinci parametre olarak gönderilecek veri, dizi olarak anahtar değer çifti olacak şekilde gönderilir. Bunu genellikle model tarafından yapılan veri tabanı isteklerinden dönen cevaplar için kullanacaksınız.
```php
namespace BaseFrame\App\Controller;
use BaseFrame\System\Core\Controller;

class FirstControllerClass extends Controller
{
    public function FirstControllerMethod()
    {
        $name = 'Ozgur';
        $surname = 'Vurgun';

        $this->view('firstView',[
            'name' => $name,
            'surname' => $surname
        ]);
    }
}
```
- View'a gönderilen veri aşağıda ki şekilde kullanılır.
```html
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>PHP BASE FRAME</title>
  </head>
  <body>
    <h1>Hello <?= $name ?>&nbsp;<?= $surname ?></h1>
  </body>
</html>
```
## Model'lar İle Çalışmak
- Öncelikle ana dizinde bulunan <code>env.php</code> dosyasında veri tabanı bilgilerinizi düzeltmelisiniz.
- Ardından controller içinde aşağıda ki gibi model isteği yapılır.
- Framework'u test edecekseniz Framework ana dizinin de test kullanımı için küçük bir sql dosyası bulunuyor, onu içeri aktarıp testleri gerçekleştirebilirsiniz. Bu dökümantasyonda ki anlatımda bu örnek sql kullanılacaktır.
```php
namespace BaseFrame\App\Controller;
use BaseFrame\System\Core\Controller;

class FirstControllerClass extends Controller
{
    public function FirstControllerMethod()
    {
        $result = $this->model('Select')->GetTable();
    }
}
```
- Select model sınıfında ki GetTable metodunun çalışması gerektiğini belirttik. Şimdi ilgili model'i oluşturmalıyız.
- <code>app/models</code> dizini altında <code>Select.php</code> dosyasını oluşturun. Ardından dosyaya aşağıda ki kodu yerleştirin.
```php
namespace BaseFrame\App\Model;
use BaseFrame\System\Core\Model;

class Select extends Model
{
    public function GetTable()
    {
      return $this->queryExec('SELECT * FROM users')->fetchAll();
    }
}
```
- Model sınıflarımız temel Model sınıfını miras alır. Veri tabanı sorgularını Model sınıfından miras aldığımız queryExec metodu ile yaparız ve sorgu sonucu dönen değeri return edip veriyi controller tarafında işleriz.

## Model'dan Dönen Verileri View'a Basmak
- Aşağıda, controller tarafında Select model sınıfında ki getTable metodunu çalıştırmak istediğimizi belirttik ve dönüş değerini result değişkenine atadık. Ardından bir view çağırdık ve result değişkeninde ki veriyi data ismi ile view'a gönderdik.
```php
namespace BaseFrame\App\Controller;
use BaseFrame\System\Core\Controller;

class FirstControllerClass extends Controller
{
    public function FirstControllerMethod()
    {
        $result = $this->model('Select')->getTable();
        $this->view('firstView', [
            'data' => $result
        ]);
    }
}
```
- Çalıştırmak istediğimiz model için <code>app/models</code> dizini altında <code>Select.php</code> dosyasını oluşturup aşağıda ki kodu ekliyoruz. Burada bir select işlemi yapılıyor ve sonuç return ediliyor.
```php
namespace BaseFrame\App\Model;
use BaseFrame\System\Core\Model;

class Select extends Model
{
    public function GetTable()
    {
      return $this->queryExec('SELECT * FROM users')->fetchAll();
    }
}
```
- <code>app/views</code> dizini altında <code>firstView.php</code> view dosyamızı oluşturuyoruz ve aşağıda ki kodu içine ekliyoruz.
- Bu kullanıma benzer şekilde update, delete, insert işlemlerini model tarafında yapıp işlemin değerini return ederek controller tarafında mantıksal işlemler yapabiliriz.
```html
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>PHP BASE FRAME</title>
  <style>
    table {
      border-collapse: collapse;
      width: 100%;
    }

    th,
    td {
      border: 1px solid #dddddd;
      text-align: left;
      padding: 8px;
    }

    th {
      background-color: #f2f2f2;
    }
  </style>
</head>

<body>
  <table>
    <thead>
      <tr>
        <th>Id</th>
        <th>Name</th>
        <th>Surname</th>
        <th>Activity</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($data as $value) : ?>
        <tr>
          <td><?= $value['id'] ?></td>
          <td><?= $value['name'] ?></td>
          <td><?= $value['surname'] ?></td>
          <td><?= $value['activity'] ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</body>

</html>
```
## Model'a Parametre Göndermek
- Aşağıda ki şekilde model metodlarına parametre gönderebilirsiniz.
```php
namespace BaseFrame\App\Controller;
use BaseFrame\System\Core\Controller;

class FirstControllerClass extends Controller
{
    public function FirstControllerMethod()
    {
        $result = $this->model('Select')->GetTable([1]);
        $this->view('firstView', [
            'data' => $result
        ]);
    }
}
```
- Parametreler model tarafında aşağıda ki şekilde kullanılır.
- Parametre veri tipinin dizi tipinde olmasına dikkat edin! Metodun imzasını tanımlarken parametre tipini dizi tipine zorlamaya alışmak iyi bir yaklaşım olacaktır bu olası dikkatsizlikler sonucu sizi uğraştırmaktan korur.
```php
namespace BaseFrame\App\Model;
use BaseFrame\System\Core\Model;

class Select extends Model
{
    public function GetTable(array $par)
    {
        return $this->queryExec('SELECT * FROM users WHERE activity = ?', $par)->fetchAll();
    }
}
```

## Statik Dosyalar İle Çalışmak
- <code>public</code> dizini altında <code>css/style.css</code> dosyasını oluşturun.
- <code>public</code> dizini altında <code>js/main.js</code> dosyasını oluşturun.
- Diğer bütün statik dosyalarınızı bu şekilde public dizini altında listeleyebilirsiniz.
```html
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="<?= $BASE_URL ?>/public/css/style.css">
  <title>PHP BASE FRAME</title>
</head>

<body>
  <script src="<?= $BASE_URL ?>/public/js/main.js"></script>
</body>

</html>
```
- Dilerseniz base url kullanmadan doğrudan kök dizini işaret ederek statik dosyalarınızı implemente edebilirsiniz. Fakat bu önerilmez, bu bazı durumlarda tutarsızklıklara sebep olabilir.
- base url sonrası yol belirtilirken ilk "/" sembolünün kullanılıp kullanılmayacağı yaptığınız base url atamasına göre farklılık gösterebilir, lütfen buna dikkat edin.

## API
- Api'ler <code>app/routes/apis.php</code> dosyası içinde tanımlanır. Normal bir route tanımlamaktan farksızdır ve tamamen aynı şekilde çalışır.
- Aşağıda ki örnek bir api tanımlaması
```php
use \BaseFrame\System\Core\Router;
Router::run('/user-registration', 'Record@userRegistration', 'post');
```
## Url'den Veri Almak
- Rotaları tanımlarken değişken değerlere sahip yolları ve numerik ID'leri yakalayabiliriz.
- Eğer bir yol almak istiyorsak rotanın yolunu belirttiğimiz ilk parametre de değişken kısım neresi olacaksa oraya <code>{url}</code> tanımı yerleştirilmelidir.
- Eğer numerik bir değer alacaksak rotanın yolunu belirttiğimiz ilk parametre de numerik alan neresi olacaksa oraya <code>{id}</code> tanımı yerleştirilmelidir.
- Örneğin şöyle bir senaryo olsun. Yapay zeka modellerinin olduğu bir kategori ve bu kategori de ki yapay zeka modellerinin her birinin bir numerik id'si olsun.
- http://localhost/php-base-frame/categories/artificial-intelligence-models/12
- Url'in yukarıda ki gibi olduğunu farz edelim.
- Bu senaryoya göre rota tanımlamasını aşağıda ki gibi yapmalıyız.
```php
Router::run('/categories/{url}/{id}', 'List@getList');
```
- Rota tanımlamasını yaptıktan sonra elbette her zaman olduğu gibi controller oluşturulur. Gönderdiğimiz değerleri sırasyıla metoda parametre olarak alırız.
```php
namespace BaseFrame\App\Controller;
use BaseFrame\System\Core\Controller;

class List extends Controller
{
    public function getList($url, $id)
    {
        $this->view('firstView', [
            'url' => $url,
            'id'  => $id
        ]);
    }
}
```
- firstView view
```html
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="<?= $BASE_URL ?>/public/css/style.css">
  <title>PHP BASE FRAME</title>
</head>

<body>
  <h1>URL: <?= $url ?></h1>
  <h1>ID : <?= $id ?></h1>
  <script src="<?= $BASE_URL ?>/public/js/main.js"></script>
</body>

</html>
```
- Unutmayın temiz ve sürdürülebilir bir geliştirme süreci için sınıfları ve metodları amacına uygun şekilde oluşturmalı görevlerini uygun şekilde kurgulamalısınız.

## Harici Kütüphaneler
- Projenize dahil etmek istediğiniz harici kütüphaneleri ve helper fonksiyon ve sınıflarını <code>app/libs</code> dizini altına ekleyebilirsiniz, sistem bu dizinde ki php dosyalarını otomatik olarak projeye dahil eder. Eklemelerinizi yaptıktan sonra tek yapmanız gereken bunları controller içinde kullanmaktır.

## 404 Yönetimi
- Eğer hiçbir controller bulunamazsa bu 404 durumudur. Bu durumu ele almak için <code>app/routes/routes.php</code> dosyasının en altında
```php
  Router::hasRoute('404', true);
``` 
- hasRoute metodu çağırılmalıdır ve ikinci parametresi true olarak verilmelidir. Varsayılan parametre değeri false' dur ve bu durumda metod 404 yönlendirme işini askıya alır. ilk parametre olarak yolu belirtmeliyiz. Örnekte olduğu gibi yolu <code>404</code> şeklinde verirsek, 404 durumunda <code>http://localhost/php-base-frame/404</code> base url'inize göre buna benzer bir adrese yönlendirme yapılır. Bu yönlendirmeye göre bir rota oluşturmamız gerekir. Örneğe göre, aşağıda ki bir rota ve controller sınıfı oluşturulmalıdır.
```php
  Router::run('/404', 'ErrorController@show404Page');
``` 
```php
namespace BaseFrame\App\Controller;
use BaseFrame\System\Core\Controller;

class ErrorController extends Controller
{
    public function show404Page()
    {
        $this->view('404');
    }
}
``` 

## Ek Bilgiler
- Rota tanımlamalarında büyük küçük harf hassasiyeti yoktur. Base Frame doğru dosyayı bulacak kadar zekidir :) Fakat okunurluk ve standart bir kullanım olarak sınıf isimlerini büyük harfle başlayarak yazmanız önerilir.
- Controller ve model' lari dizinler halinde kümeleyebilirsiniz.
  - Tek yapmanız gereken, rotada bu yolu belirtmektir. 
  - Örneğin <code>controllers/admin</code> dizini içerisinde bir controller tanımlamak isterseniz rota tanımlamasında sınıf tanımlamasını aşağıda ki gibi yapmanız gerekir. Bu "admin dizini altında Pages adında bir sınıf var bu sınıf içinde ki homePage metodunu çalıştır" demektir.
  ```php
  Router::run('/', 'admin/Pages@homePage');
  ```
- Sınıf isimleri ile sınıf dosya isimleri aynı olmalıdır! Büyük küçük harf hassasiyeti yoktur fakat bu konuda tutarlı davranmak iyi bir programlama yaklaşımı olacaktır.
- Sınıf isimlerinin ve sınıf dosyaların isimlerini büyük harfle başlayarak yazmak standartlara uygun ve daha okunaklı bir yaklaşımdır.
- view dosylarını kümeleyebilirsiniz. Tek yapmanız gereken view'i çağırırken yolunu da belirtmelisiniz.
- Örnek:
  ```php
  $this->view('admin/homePage');
  ```
- Yerel geliştirme ortamınızda <code>.gitkeep</code> dosyalarını kaldırabilirsiniz.







