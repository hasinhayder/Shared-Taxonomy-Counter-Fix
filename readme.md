# Shared Taxonomy Counter Fix for WordPress

This plugin fixes the taxonomy counter in WordPress admin panel if the taxonomy is shared across multiple post types. It's a known bug in WordPress. 

Conside the following situation

1. You are using **"category"** in **posts** as well as in a cpt **"cpt-x"**
2. You have two posts, and both of them are listed in two categories *"Food"* and *"Beverage"*
3. You have two **"cpt-x"** posts, both of them are categorized as *"Food"* 
4. Now, when you come to the ***categories*** menu (in WP Admin Panel) you will see that *"Food"* and *"Beverage"* are shwing wrong counter as **"3"** and **"1"**, while they should be **"1"** and **"1"** for posts, and **"2"** and **"0"** for **"cpt-x"**. 

It's a bug in WordPress, has been mentioned in Trac Ticket [#19031](https://core.trac.wordpress.org/ticket/19031) and countless times in different support sites as well as in StackExchange forums. This plugin is a quick fix for this known issue. 