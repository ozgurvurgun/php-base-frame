# php-base-frame

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

- app / routes dizini altında <code>routes.php</code> dosyasına aşağıda ki routing kodunu ekleyin. Bunun anlamı: Base Url algılanırsa FirstController sınıfının içinde ki firstMethod metodunu çalıştır.
```php
Router::run("/", "FirstController@FirstMethod");
```
- app / controllers dizini altında <code>FirstController.php</code> dosyasını oluşturun ve aşağıda ki kodu ekleyin.
```php
namespace BaseFrame\App\Controller;
use BaseFrame\System\Core\Controller;

class FirstController extends Controller
{
    public function firstMethod()
    {
        $this->view("firstView");
    }
}
```

- app / views dizini altında <code>firstView.php</code> dosyasını oluşturun.
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
- Şu ana kadar url'e göre view basmayı öğrendik.