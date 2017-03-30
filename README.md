# clean-architecture

[![Code Climate](https://codeclimate.com/github/damianopetrungaro/clean-architecture/badges/gpa.svg)](https://codeclimate.com/github/damianopetrungaro/clean-architecture)
[![Build Status](https://travis-ci.org/damianopetrungaro/clean-architecture.svg?branch=master)](https://travis-ci.org/damianopetrungaro/clean-architecture)

Package for isolate your domain code from framework dependency

What are Domain,Application and Infrastructure layer? [Click here](http://dddsample.sourceforge.net/architecture.html) for a resume.

## Why?

#### Why did you code this package?

When i code, i usually isolate the Domain layer from Application layer and Infrastructure layer, and every time i do it i need to re-build a set of objects that helps me doing this.

Those objects often are a Request, a Response and some Errors.

This package is born for me, to do not re-build this set of objects, also avoiding some copy paste from different projects.

#### Why should you isolate your domain code from Application and Infrastructure dependecies?

Imagine that your PHP application is currently built on top of Laravel framework.

And use a modern frameworks (such Laravel, Symfony or Slim) is a very good thing. Helps you to write a better code without reinvent the wheel.

But what if you want/must switch your current framework for performance, architectural or other reasons to an another one?

Usually this is very painful, and you are despondent to change it.
This choose bind you to a tool that might not be as good as before for your project.

And this is only an example. There can be a lot of more reasons why you want to change framework.


#### How can i isolate it?

Using some DDD concepts, you can totally (or quasi) isolate your domain code from the Application layer (Laravel for example) and from the Infrastructure layer (Postgresql or Mysql for example).

So the Domain of my application is not relegated to a particular framework/package/database, and can be "easily" switched.

#### What hepls me to realize this package?

There are some books that helped me to "think" in this way. Here some of them:

[Clean PHP](https://leanpub.com/cleanphp)

[DDD in PHP](https://leanpub.com/ddd-in-php)

[DDD by Evans](https://domainlanguage.com/ddd/)

## A Minimal Documentation

- Common

  - Collections
  
  - Enum
  
- Mapper

- Use Cases

  - Request
  
  - Response
  
  - Validation
  
  - Error
  
- Persistence

  - Transaction

## A Practical Example

- Slim
