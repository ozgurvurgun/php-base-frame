# php base frame

>PHP Base Frame Nedir ? Amacı Nedir ?
<p>
Laravel, Symfony vb gibi bir framework kullanmaya başladıysak ve bu sistemlerin OOP, MVC... gibi kavramlarını ve bunların metodolojilerini içselleştirmediysek günün sonunda çok efektif işler yapıp yapmadığımız bir soru işaretidir. Kullandığı sistemin nasıl çalıştığını iyi kavramış bir geliştirici hiç şüphesiz çok daha yüksek kalitede geliştirme yapacaktır.
</p>
<p>
PHP Base Frame temel olarak bu noktada ki boşluğu doldurmaya çalışıyor. Sistemin core kodu oldukça kısa ve sistemin uçtan uca nasıl çalıştığı dakikalar içinde anlaşılabilecek basitlik düzeyinde. Nesne yönelimli programlamada yeni iseniz ve bu paradigmanın MVC yaklaşımına nasıl implemente edildiğini anlamak istiyorsanız, PHP Base Frame bunları anlama noktasında güzel bir bakış açısı sağlıyor.
</p>
<p>
Framework çalışma zamanında ilk olarak routing sistemi çalışıyor. Burada ki parse işlemi sonrası çalıştırılacak controller bulunuyor ve ardından ilgili controller çalıştırılıyor. Controller da mantıksal işlemler yapılıyor. Duruma göre model'lar çalıştırılıp veri tabanından dönen değerler burada işlenip view'a gönderiliyor veya direkt view basılıyor. Sistem kabaca bu şekilde çalışıyor. Aşağıda kı kullanma kılavuzunda sistemin nasıl çalıştığını daha net göreceksiniz.
</p>

## İlk Proje
- Kurulum
```bash
git clone https://github.com/ozgurvurgun/php-base-frame.git
```
- Öncelikle ana dizinde ki <code>env.php</code> dosyanında base url tanımlaması yapılmalıdır. Proje klasöründe değişklik yapmadıysanız base url tanımı varsayılan olarak sorun çıkarmayacaktır. Dizini değiştirdiğinizde base url değerini değiştirmeyi unutmayın!

- <code>app/routes</code> dizini altında <code>routes.php</code> dosyasına aşağıda ki routing kodunu ekleyin. Bunun anlamı: Base Url algılanırsa FirstControllerClass sınıfının içinde ki FirstControllerMethod metodunu çalıştır.
```php
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

- <code>app/views</code> dizini altında <code>firstView.php</code> dosyasını oluşturun.
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
- Şu ana kadar url'e göre view çağırmayı öğrendik.

## View'a Veri Göndermek
- View çağırılırken view adından sonra ikinci parametre olarak gönderilecek veri, dizi olarak anahtar değer çifti olacak şekilde gönderilir. Bunu genellikle model tarafından yapılan veritabanı isteklerinden dönen cevaplar için kullanacaksınız.
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
- Öncelikle ana dizinde bulunan <code>env.php</code> dosyasında veritabanı bilgilerinizi düzeltmelisiniz.
- Ardından controller içinde aşağıda ki gibi model isteği yapılır.
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
- Controller tarafında Select model sınıfında ki getTable metodunu çalıştırmak istediğimizi belirttik ve dönüş değerini result değişkenine atadık. Ardından bir view çağırdık ve result değişkeninde ki veriyi data ismi ile view'a gönderdik.
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
```php
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

