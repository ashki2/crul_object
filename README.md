# crul_object
PHP class for crawling websites, extracting HTML content with XPath, and sending/receiving JSON data. 
# PHP Web Crawler System

## توضیح کلی سیستم

این پروژه یک **سیستم کرالر PHP** است که به طور خودکار داده‌ها را از **چندین وب‌سایت مختلف** جمع‌آوری کرده و به صورت **JSON** ذخیره می‌کند. عملکرد سیستم به طور کلی شامل مراحل زیر است:

1. **اتصال به سایت‌ها:**  
   سیستم با استفاده از cURL به صفحات وب یا APIهای هر سایت متصل می‌شود.

2. **استخراج داده‌ها:**  
   - اطلاعات از **HTML صفحات** با XPath استخراج می‌شود.  
   - اطلاعات JSON از APIها دریافت و پردازش می‌شود.

3. **پردازش و استانداردسازی:**  
   - داده‌ها به شکل استاندارد و قابل استفاده ذخیره می‌شوند.  
   - مقادیر مختلف (مثل قیمت‌ها، مقادیر متنی و غیره) یکسان‌سازی می‌شوند تا خروجی‌ها منظم باشند.

4. **ذخیره‌سازی:**  
   داده‌های جمع‌آوری شده در **فایل JSON** ذخیره می‌شوند و شامل تاریخ و ساعت آخرین بروزرسانی هستند.

5. **مدیریت خطا و پایداری:**  
   - سیستم در صورت بروز خطا (مثل مشکل شبکه یا تغییر ساختار سایت) توقف نمی‌کند و ادامه کار می‌دهد.  
   - داده‌های معتبر ذخیره می‌شوند و اجرای کرالر امن و پایدار است.

**هدف اصلی:** فراهم کردن یک ابزار **عمومی و قابل استفاده مجدد** برای جمع‌آوری و ذخیره داده‌های سایت‌ها به صورت خودکار و منظم.

---

## System Overview

This project is a **PHP web crawler system** that automatically collects data from **multiple websites** and stores it as **JSON files**. The overall workflow of the system includes the following steps:

1. **Connecting to websites:**  
   The system connects to web pages or APIs of each site using cURL.

2. **Data extraction:**  
   - Information is extracted from **HTML pages** using XPath.  
   - JSON data from APIs is retrieved and processed.

3. **Processing and standardization:**  
   - Data is stored in a **standardized and usable format**.  
   - Various values (like prices, text values, etc.) are standardized to ensure organized output.

4. **Storage:**  
   Collected data is saved in **JSON files**, including the date and time of the last update.

5. **Error handling and stability:**  
   - The system continues running even if errors occur (e.g., network issues or changes in website structure).  
   - Valid data is preserved, ensuring safe and stable crawler execution.

**Main goal:** To provide a **public and reusable tool** for automatically collecting and storing website data in an organized manner.
