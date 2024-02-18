# php-base-frame

>PHP Base Frame Nedir ? Amacı Nedir ?
<p>
Laravel, Symfony vb gibi bir framework kullanmaya başladıysak ve bu sistemlerin OOP, MVC... gibi kavramlarını ve bunların metodolojilerini içselleştirmediysek günün sonunda çok efektif işler yapıp yapmadığımız bir soru işaretidir. Kullandığı sistemin nasıl çalıştığını iyi kavramış bir geliştirici hiç şüphesiz çok daha yüksek kalitede geliştirme yapacaktır.
</p>
<p>
PHP Base Frame temel olarak bu noktada ki boşluğu doldurmaya çalışıyor. Sistemin core kodu oldukça kısa ve sistemin uçtan uca nasıl çalıştığı dakikalar içinde anlaşılabilecek basitlik düzeyinde. Nesne yönelimli programlamada yeni iseniz ve bu paradigmanın MVC çerçevesine nasıl implemente edildiğini anlamak istiyorsanız, PHP Base Frame bunları anlama noktasında güzel bir bakış açısı sağlıyor.
</p>
<p>
Framework çalışma zamanında ilk olarak routing sistemi çalışıyor. Burada ki parse işlemi sonrası çalıştırılacak controller bulunuyor ve ardından ilgili controller çalıştırılıyor. Controller da mantıksal işlemler yapılıyor. Duruma göre model'lar çalıştırılıp veri tabanından dönen değerler burada işlenip view'a gönderiliyor veya direkt view basılıyor. Sistem kabaca bu şekilde çalışıyor. Aşağıda kı kullanma kılavuzunda sistemin nasıl çalıştığını daha net göreceksiniz.
</p>