# Assignment02

## Project title/heading

Bringlu - Modern advertising platform which connects businesses and advertisers.

## Project description

In this **section** I am going to talk about newly implemented features, why they are usefull in Bringlu application and what technologies are involved behind them.

* **Eloquent** Regarding my previous feedback I have not implemented models relationships and did not use ORM (Object Relational mapper) which is one of the best feature that Laravel framework can offer. Doing research and adding Laravel Eloquent I understood that it makes my interaction with the database much easier. It became so easy to perform common database operations such as creating, updating and deleting records without having to write complex SQL queries. Eloquent also helped me to make relationships between a few tables including `users`, `adverts`, `advert_media`, `advert_categories` and `advertisers_ads_status`.

* **New tables** To make my application more complex, I have also created 2 new tables:
  * `advertisers_viewed_ads` - tracks when advertisers clicks (views) on any advert campaign. This table records who viewed the advert campaign `advertiser_id`, which advert was viewed `advert_id`, to whom that viewed advert belongs `user_id` and when this action was performed `viewed_at`.
  * `advertisers_ads_status` - this table tracks status of the requested adverts to be advertiser by advertiser. Data which is stored in this table represents the person who requested the advert `advertiser_id`, which advert was requested `advert_id`, to whom that advert belongs `user_id`, current advert status (when advertiser requests = pending, when business customer confirms = confirmed or rejects = rejected) `advert_status`. There is a `extra_details` column for advertiser message to the business customer and also `last_actioned_at` - when was the last time status was updated. In addition, there is a logic implemented that advertiser can request the same advert to advertise only once, after that request will be rejected.

* **New controllers** I have added more functions and complexity for `BusinessController` and `AdvertController`. New methods essentially adds new features to the application which I will mention in the other sections. Furthemore, I have created `SocialController` which is responsible for third-party authorisation (more about it later).

* **Middlewares implementation** this was the best way to filter HTTP requests entering my application different routes. Different middlewares provided me exta features including:
  * **authentication** - only let logged in users to access specific routes;
  * **authorisation** - determine whether a user has the rights to access a specific resource or perform specific action. In my case, prevent advertisers accessing `/business` routes and for business customer forbid to access `/advertiser` routes. Otherways, they are redirected back to their controller.
  * **rate limiting** - to control the rate at which users can access `/advertiser/{advert}/show` view and submit advert request.

* **PDF conversion** - advertisers can convert any advert's details to the PDF document. To implement this feature I have used package called `barryvdh/laravel-dompdf`. This package provided a simple way to generate PDF documents from HTML view. Pdf document is downloaded to the user computer by passing `Advert $advert` model converted to the array for a view which is loaded with PDF package.

* **Complex queries using Laravel Eloquent** - to get a total count of pending/confirmed/rejected adverts requests which belongs to the specific customer I have used Eloquent Model as a query builder by adding additional constraints such as `where` and `orderBy`.

* **Third-party authorisation via GitHub with HTTP session** - to implement this feature I have used Socialite package. To configure this package for **Bringlu** application was more difficult than expected. After OAuth (Github) provider's login page, retrieved user details are inserted to the `users` table. However, `account_type` column cannot be retrieved from the GitHub. To sort this problem, before user is redirected to OAuth page, application is showing form for the user to pick the account type and stores it in the session. Before user details are inserted into the table, session is retrieved with `account_type` variable.

* **Resetting passwords** - this feature allows users who have forgotten their password to reset it and regain access to their account. It is crucial feature providing a good user experience and ensuring the security of the application. To make this working I have used pre-built Laravel`s starter kit for authentication system, configured for my case. Also, application can send actual emails with reset password link.

* **Mailing service** - Bringlu application can send emails for the users when advertise request has been made. It will instantly inform the business customer (advert campaign owner) that the advert request is created and he needs to take further actions, otherwise request will be rejected automatically within 24 hours by task scheduler (more about this in the next section). Email service is configured with email service provider - Mailgun. However, only verified recipients can receive actual emails, as domain could not be verified.

* **Task scheduler** - this feature allows to schedule tasks to be run automatically at specific intervals. In *Bringlu* application, task scheduler looks for pending advert requets and automatically rejects them daily by updating database record in the `advertisers_ads_status` table from 'pending' to 'rejected'. However, this can work properly when application is hosted on the server or is set up properly on the host machine.

* **Advanced Tailwind CSS** - this CSS framework helped me to generate beautiful views, including user interfaces, tables, cards and other elements, by providing a set of utility classes.

* **CI/CD** - *GitHub Actions* was used as a continous integration and continous delivery platform for automating processes within my repository on GitHub. Essentially, everytime when code is pushed to the repository (`develop` branch), it needs to pass all the tests in order to be confirmed and merged.

## Project installation

To run my **Bringlu** application on the **localhost** I will be using XAMPP.

1. Firstly we need to download source code from the **master** branch.
2. Source code folder needs to be added in the /xampp/htdocs/[project folder]
3. Create new database in the PHP MyAdmin running the MySQL server in XAMPP
<p align="left">
  <img src="https://user-images.githubusercontent.com/57880277/199973487-8fd4297d-6372-4812-87e1-0e866b684184.PNG" alt="Database"/>
</p>
4. Modify .env in the source (change the database name, username and password)
5. You also need to have Node.js and Git installed on your local machine! (**Set node PATH if necessary**)
6. Download composer (run cmd in the project directory and paste following command)


 ```
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php -r "if (hash_file('sha384', 'composer-setup.php') === '55ce33d7678c5a611085589f1f3ddf8b3c52d662cd01d4ba75c0ee0459970c2200a51f492d557530c71c15d8dba01eae') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
php composer-setup.php
php -r "unlink('composer-setup.php');"
```

7. Start Apache and MySQL server in XAMPP
8. Open git-bash.exe from the cmd (/([your disk]/git/git-bash.exe)
9. Install Node dependencies and run the dev script from git-bash.exe on that project directory

```
npm install
npm run dev
```

11. Check if composer was succesfully installed
<p align="left">
  <img src="https://user-images.githubusercontent.com/57880277/199980663-22724bc7-9a30-42ce-b5f1-ab3da7252fd1.PNG" alt="Composer"/>
</p>
11. Run migration (to create 6 main tables: `users`, `adverts`, `advert_categories`, `media_type`s, `advertisers_ads_status` and `advertisers_viewed_ads`)


```
php artisan migrate
```


12. Seed the database (actually data from **JSON** file)


```
php artisan db:seed
```

13. Make sure that tables are created and data has been successfully inserted (users table must be empty!)
<p align="left">
  <img src="https://user-images.githubusercontent.com/57880277/199980797-e6ecf542-8045-409d-8151-cfa05a848ad0.PNG" alt="Database"/>
</p>
14. Open the web application in your browser and register as a **Business customer** first (you should see some adverts created after successfull registration)

![third](https://user-images.githubusercontent.com/57880277/207996596-fc57bfd0-a20e-4e84-a5ac-8ef40adb4f7c.png)



## Project usage

### Home page

<p align="left">
  <img src="https://user-images.githubusercontent.com/57880277/207995289-5d95a1fe-0049-4883-8e3e-b15a26f3b85c.png" alt="Database"/>
</p>

After seeding database, I will register to **Bringlu** application using third-party authentication (**GitHub**)

### Account type selection page

<p align="left">
  <img src="https://user-images.githubusercontent.com/57880277/207995922-a42f56a0-3678-43a6-8a7a-fccf894fa994.png" alt="Database"/>
</p>

Selecting to register as a Business customer

### Business customer main (index) page

<p align="left">
  <img src="https://user-images.githubusercontent.com/57880277/207996596-fc57bfd0-a20e-4e84-a5ac-8ef40adb4f7c.png"/>
</p>

After successful GitHub authentication, user is redirected to the index page which belongs for **Business Customer**

### Manual registration page

<p align="left">
  <img src="https://user-images.githubusercontent.com/57880277/207997467-ccc0f69b-fd13-42d8-bc6c-9ecde6eae807.png"/>
</p>

This time I will register manually as a **Advertiser** in order to perform certain actions that this type of customer has

### Advertiser Home (index) page 

<p align="left">
  <img src="https://user-images.githubusercontent.com/57880277/207998428-d5054790-3340-42b2-80e2-76563bd318eb.png" alt="Database"/>
</p>

After succesfull registration, user is redirected to **Advertiser** index page. This screenshot also demonstrates authorisation middleware implementation.
If user will try to access `/business` route, it will instantly be redirected back to this page with following error message popover.

### Advert details page

<p align="left">
  <img src="https://user-images.githubusercontent.com/57880277/207998789-c8308a06-211c-40df-bcd2-6733d56250ee.png" alt="Database"/>
</p>

In this page, user can view advert details and send request for business customer to advertise his advert.

### Successful advert request

<p align="left">
  <img src="https://user-images.githubusercontent.com/57880277/207999014-dd4c8466-2d32-4d96-8165-e24cba359a8c.png" alt="Database"/>
</p>

### Trying to request same advert second time will get this errror

<p align="left">
  <img src="https://user-images.githubusercontent.com/57880277/207999269-8ffe43cf-72d0-4462-8fe0-cd3904067d19.png" alt="Database"/>
</p>


### Advert activity page

<p align="left">
  <img src="https://user-images.githubusercontent.com/57880277/207999572-55d850c8-c7c8-4a7a-9672-6a394fa158f2.png" alt="Database"/>
</p>

Adverts can have 3 different type of status: **pending**, **confirmed**, **active**

### Pending adverts page **Business customer** page

<p align="left">
  <img src="https://user-images.githubusercontent.com/57880277/207999948-459cd8fb-ad5c-463f-8d8d-2ff2420507ad.png" alt="Database"/>
</p>

After that business customer can **confirm** or **reject** pending requests (status will be automatically updated for **advertiser**)

### Confirmed advert request message

<p align="left">
  <img src="https://user-images.githubusercontent.com/57880277/208000416-5fc71426-a79c-42a2-b09f-eeaea5949037.png" alt="Database"/>
</p>

### Rejected advert request message

<p align="left">
  <img src="https://user-images.githubusercontent.com/57880277/208000561-da06f231-e916-43a0-b651-ea49fa4bda44.png" alt="Database"/>
</p>

### Recent activity card was just updated!

<p align="left">
  <img src="https://user-images.githubusercontent.com/57880277/208000676-b28bf164-e790-4a61-8c23-2d2aaeb5a8d8.png" alt="Database"/>
</p>

### All adverts request page (**Business customer** view)

<p align="left">
  <img src="https://user-images.githubusercontent.com/57880277/208000831-2d5a86ca-2262-4d24-8bd2-52bd631ffd57.png" alt="Database"/>
</p>

### Adverts activity table just got updated

<p align="left">
  <img src="https://user-images.githubusercontent.com/57880277/208001038-51ade3d3-62d2-4ed8-a9a8-780d2ec2227d.png" alt="Database"/>
</p>

### Confirmed advert details page can be easily converted to PDF document

<p align="left">
  <img src="https://user-images.githubusercontent.com/57880277/208001181-9246356b-87c1-4148-946f-02ebd16a6336.png" alt="Database"/>
</p>

### Confirmed advert details generated PDF document

<p align="left">
  <img src="https://user-images.githubusercontent.com/57880277/208001341-793a8cb8-f1d2-4a56-a328-3d5d7f566f74.png" alt="Database"/>
</p>

## Project testing

Before running **Bringlu** application it is recommended to run tets. Running tests on Laravel helps ensure the quality and reliability of the code. Also, 
it validates that the most important features are working smoothly. To run tests on **Bringlu** application, this command line needs to be executed on **git-bash** terminal:

<p align="left">
  <img src="https://user-images.githubusercontent.com/57880277/208112779-7758742b-662d-451d-883a-bcbc29b069fa.png" alt="Database"/>
</p>

### Proves that application runs smoothly and can be safely deployed

<p align="left">
  <img src="https://user-images.githubusercontent.com/57880277/208113997-dbe8acec-282f-453c-8f4d-0abff0d15644.png" alt="Database"/>
</p>

After successful execution, it can be seen that all tests passes including:
* **Auth** (some tests are default and some are **created/updated** by me to meet the special application requirements),
* Actions within **Business** Controller,
* Actions within **Advertiser** Controller,
* Third-party authentication via **GitHub**

## Reflective analysis

Working on the **Assignment02** and implementing complex features I found out that **Middleware** is one of the most powerful and useful features of the framework. Middlware allows you to define a set of rules that are applied to incoming HTTP requests before they are handled by the **Bringlu** application. Middleware particularly helped me to perform a variety of tasks including:
* **authentication** - only let logged in users to access `/business` and `/advertiser` routes. This is essential for protecting posted advert campaign details and preventing unauthorised access to the resources, such as sending request to advertise for business customers.
* **authorisation** - allows to control access to resources and actions evaluating the `account_type`. Authorisation implementation in **Bringlu** application prevents business customers from accessing advertisers (`/advertiser`) resource and for advertisers itself  accessing businesses (`/business`) routes. Everytime `authorise-adv` or `authorise-business` middleware is called, it extracts `account_type` from `Auth::user()` and checks if it matches with the particular account type (**advertiser** or **business**). If it matches, then it permits access to the called route, otherwise redirects back to the original user route.
* **rate limiting** - this middleware is called `throttle` and it prevents excessive or abusive use of application's resources. In my case, `throttle:advertShow` will limit maximum 5 requests per minute and `throttle:advertRequests` up to 2 requests/min when submitting advert request for the **Business Customer**. If an attacker is attempting to flood **Bringlu** database with a lot of advert requests, rate limiting middleware will insatntly block it and redirect user to the 429 (Too Many Requests) error page. Additionaly, rate limiting can help to prevent advertisers from accidentally submitting to many requests, which can improve overall performance and reliability of the **Bringlu** application.

One of the things I like the most about Laravel's middleware is flexibilty. Middleware rules can be easily attacked to a route , group of routes or even the whole resource. Alernatively, middleware can be implemented in a controller by using `midleware` method. Middleware needs to be specified in the `__construct()` function. Any method called within controller will be handled by the specified middleware. In addition, middleware can be used on individual actions within controller class. This allows to implement diffrenet middleware for different actions, rather than applying the same middleware to all actions. This makes it easier to manage and organise middleware, as you can apply multiple middleware rules without having to specify each middleware individually.

However, implementing middleware using previously mentioned method seems to be inconvienent for me. Firstly, specifying middleware on the route rather than in the controller provides several benefits:
  * better organisation,
  * easier reuse,
  * ability to apply multiple middleware to a route,
  * makes code more consistent and improves maintainability of the source code.

In addition, I have tried to replace middleware with route model binding. Essentially, it allows to specify a model class for a route parameter, and Laravel will automatically inject the the model instance for that parameter into the route or controller. Therefore, it might provides a convenient alternative to using middleware for accessing model instances but some drawbacks needs to be highlighted. It looks like route model binding is limited to only accessing instances of classes that extends Eloquent Model (`Illuminate\Database\Eloquent\Model`). Also, it makes routes more tightly coupled to the database structure. In another words, if the database structure or class names of models will be changed, routes and controllers reflecting that class needs to be updated as well. As a rsult, it makes application less flexible and harder to maintain in the long run.

Overall, Laravel middleware is a flexible and easy-to-use tool that provides a convenient way to filter HTTP requests and responses. Its flexibility allows developers to easily customise theri application to meet their specific needs, and its ease of use makes it a valuable part of the Laravel web development toolkit.



