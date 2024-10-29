=== Affiliate Tools Việt Nam ===
Author: Khuyến Mãi Mua Sắm
Contributors: leduchuy89vn, gearazk
Tags: seo, link, links, publisher, post, posts, comments, affiliate, accesstrade, masoffer
Requires at least: 2.6
Tested up to: 4.7
Stable tag: 3.5.15
License: GPLv2

Tạo link AFFILIATE Accesstrade, Masoffer tự động. Chuyển đổi qua lại dễ dàng giữa Accesstrade, Masoffer và Lazada.

== Description ==
(English below)

**Các tính năng chính**

Affiliate Tools Việt Nam được phát triển dành cho các bạn làm affiliate ở Việt Nam, trong đó bao gồm 03 tính năng chính:

1. Chuyển đổi link thường thành link affiliate giúp ghi cookie kiếm tiền MMO cho các bạn sử dụng nền tảng Accesstrade hoặc Masoffer.
2. Thống kê số lượng click vào link affiliate.
3. Chuyển đổi link ra ngoài (external link) thành link trong (internal link) giúp giảm mất điểm SEO. Có tùy chỉnh delay (tùy chỉnh được từ 0-3s) trước khi chuyển trang dùng cho mục đích SEO.

**Lưu ý**

* Plugin sử dụng phương pháp tạo link v0 áp dụng dành cho dynamic link của Masoffer nên link nhìn sẽ khác với link được tạo bằng công cụ web (v1) của Masoffer.
* Phiên bản 0.1 là phiên bản hoàn toàn miễn phí. Tuy nhiên, những phiên bản sau sẽ có chính sách giá cho những tính năng mới, ngoài những tính năng đang miễn phí ở bản 0.1.
* Phiên bản 0.2 chỉ cập nhập bổ xung thêm danh sách 41 campaign của Accesstrade & và 29 campaign của Masoffer.
* Plugin này không còn xung đột với các plugin caching, bao gồm cả Hyper Cache.

**Tính năng đang phát triển**

* Dashboard xem doanh số của cả hai nhà Accesstrade & Masoffer trên cùng một dashboard duy nhất.
* Thống kê tính hiệu quả: click/orders thành công. Thống kê theo nhà cung, theo loại sản phẩm và theo sản phẩm.

(English Description)

Affiliate Tools was developed based on "No External Link" concept, it provide 02 main features:

* Mask all external links - make them internal or hide. On your own posts, comments pages, authors page - no more PR\CY dropping!
* Rewrite external links to affiliate url (based on syntax of Accesstrade & Masoffer).
* Dashboard support statistic link click count.

This plugin also has many cool features - outgoing clicks stats, fulllink masking, custom redirects,masking links to digital short code and base64 encoding and so on.It is designed for specialists who sell different kind of advertisment on their web site and care about the number of outgoing links that can be found by search engines. Now you can make all external links internal!

**Warning**

This plugin may conflict with your caching plugins, including Hyper Cache. Usually adding redirect page to caching plugin exclusions works fine, but I can't garantee that everything will go smoothly. By the way, after deactivation this plugins leaves no traces in your database or hard drive - so if you have you have problems after deactivation - please, search them in another source, for example, caching plugins. Flushing cache should help.

**TODO Features**

* Revenue dashboard support Accesstrade & Masoffer.

== Installation ==

Sau khi cài đặt từ Wordpress Plugins, vào mục Settings => Affiliate Tool để thiết lập tài khoản Accesstrade hoặc Masoffer dùng tạo link affiliate. Thông tin này chỉ có tác dụng duy nhất là dùng để tạo link affiliate và không thể làm gì khác ngoài chức năng này. Vui lòng kiểm tra lại với Masoffer và Accesstrade nếu chưa rõ về tính năng này.

1. Với Accesstrade:
Thiết lập "Accesstrade secret key" bằng chuỗi ký tự nằm sao <domain_name>/deep_link/<accesstrade_secrect_key> của mục tạo Deep Link:
VD: https://pub.accesstrade.vn/deep_link/4423945991349612XXX thì chuỗi accesstrade_secrect_key là 4423945991349612XXX.

2. Với Masoffer:
Thiết lập "MasOffer secret key" bằng tên tài khoản đăng nhập trang quản lý pub.masoffer.com của bạn.

== Frequently Asked Questions ==

= Sử dụng Affiliate Tools Việt Nam có bị mất tài khoản không? =

Affiliate Tools không yêu cầu người sử dụng phải cung cấp tài khoản và mật khẩu đăng nhập các nền tảng affiliate nào. Affiliate Tools chỉ sử dụng chuỗi định danh (secrect key) đối với Accesstrade và tên tài khoản với Massoffer. Chuổi định danh và tên tài khoản này hiển thị công khai trên bất kỳ link affliate được tạo bởi hai nền tảng kể trên và không có tác dụng cho phép Affiliate Tools nhìn thấy hoặc sử dụng bất kì thông tin nào liên quan đến tài khoản Accesstrade hoặc  Masoffer của bạn. Chắc chắn 110% rằng tài khoản của bạn an toàn trước Affiliate Tools.

= Affiliate Tools có phải là một nền tảng Affiliate không? =

Affiliate Tools không phải là một nền tảng tiếp thị liên kết (affiliate) mà chỉ là một plugin cung cấp tính năng tạo link affiliate cho hai nền tảng Accesstrade và Masoffer (Lazada sẽ sớm được cập nhập). Affiliate Tools không có ý định trở thành một nền tảng Affiliate mà sẽ mãi mãi là công cụ trung gian hổ trợ các bạn MMO kiếm tiền từ affiliate. Tương lai Affiliate Tools sẽ cung cấp thêm tính năng tổng hợp thông tin khuyến mãi của tất cả nền tảng affiliate ở Việt Nam.

== Changelog ==

= 0.3.16 =
* Adayroi.com đã trở lại

= 0.3.9, 0.3.10, 0.3.11, 0.3.12, 0.3.13, 0.3.15, 0.3.16, 0.3.17 =

* Add thefaceshop, daithanhgroup, luxstay, rio, alotrip, dichungtaxi, klook.com
* Add Aeonshop, Nama.vn, Eropi.com
* Add Agoda, Booking, Vietravel
* Add canifa.com
* Fix double declare Mobile_Detect
* Fix warning

= 0.3.7, 0.3.8 =

Thêm tính năng tạo link lazada mobile, thêm option force user sử dụng mobile app (Lazada.vn).

= 0.3.2, 0.3.3, 0.3.4, 0.3.5, 0.3.6 =

* Thêm advertiser mới: https://masoffer.com/mo/dynamic-link/
* Thêm advertiser mới
* Tạm thời ngừng chạy Adayroi.com do Adayroi ngừng affiliate đến Tháng 6 2017
* Thêm tính năng tùy chỉnh nền tảng cho từng site.
* Thêm nhà cung mới: Atadi, Bookin, Divui, VietTravel.

= 0.3 =

1. Thêm nhà cung mới: www.dyoss.com
2. Thêm shortcut Settings

= 0.2 =

1. Bổ xung thêm danh sách 41 campaign của Accesstrade & và 29 campaign của Masoffer.
2. Thay đổi giao diện dashboad thống kê click.

= 0.1 =
Version đầu tiên với 03 tính năng cơ bản:
1. Chuyển đổi link thường thành link affiliate, áp dụng cho hai nền tảng Accesstrade và Masoffer.
2. Thống kê số lượng click vào link affiliate.
3. Chuyển đổi link ra ngoài (external link) thành link trong (internal link) giúp giảm mất điểm SEO.

== Upgrade Notice ==
== Screenshots ==

1. Dashboard hiển thị số lượng click vào link affiliate theo Ngày, Tháng và Năm tùy chọn.
2. Các tùy chọn thống kê.
3. Dashboard hiển thị top 10 link được click vào nhiều nhất.
4. Trang thiết lập hai thông tin cơ bản để kiếm tiền với affiliate thông qua hai nên tảng Accesstrade và Massoffer.
