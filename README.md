# clean-architecture

[![Code Climate](https://codeclimate.com/github/damianopetrungaro/clean-architecture/badges/gpa.svg)](https://codeclimate.com/github/damianopetrungaro/clean-architecture)
[![Build Status](https://travis-ci.org/damianopetrungaro/clean-architecture.svg?branch=master)](https://travis-ci.org/damianopetrungaro/clean-architecture)

Package for isolate your domain code from framework dependency

What are Domain,Application and Infrastructure layer? [Click here](http://dddsample.sourceforge.net/architecture.html) for a resume.

## Why?

#### Why did you code this package?

When I code, I usually isolate the Domain layer from Application layer and Infrastructure layer, and every time I do it I need to re-build a set of objects that helps me doing this.

Those objects often are a Request, a Response and some Errors.

This package is born for me, to avoid re-building such set of objects, also avoiding some copy/paste from different projects.

#### Why should you isolate your domain code from Application and Infrastructure dependencies?

Imagine that your PHP application is currently built on top of Laravel framework.

And use a modern frameworks (such Laravel, Symfony or Slim) is a very good thing. Helps you to write a better code without reinvent the wheel.

But what if you want/must switch your current framework for performance, architectural or other reasons to an another one?

Usually this is very painful, and you are despondent to change it.
This choose bind you to a tool that might not be as good as before for your project.

And this is only an example. There can be a lot of more reasons why you want to change framework.


#### How can I isolate it?

Using some DDD concepts, you can totally (or almost) isolate your domain code from the Application layer (Laravel for example) and from the Infrastructure layer (Postgresql or Mysql for example).

So the Domain of my application is not relegated to a particular framework/package/database, and can be "easily" switched.

#### What hepls me to realize this package?

There are some books that helped me to "think" in this way. Here some of them:

[Clean PHP](https://leanpub.com/cleanphp)

[DDD in PHP](https://leanpub.com/ddd-in-php)

[DDD by Evans](https://domainlanguage.com/ddd/)

## A Minimal Documentation

- Common

  - Collections
  
    - Collection
      
      An interface to use instead an array of objects.
    
    - ArrayCollection
    
      An implementation of Collection using php array.
  
  - Enum
  
    - Enum
      
       Used for give Enum support on PHP.
      
    - ReflectionEnum
    
      An implementation of Enum using reflection.
  
- Mapper

  - Mapper
  
    An interface to use for transform object into array and viceversa.

  - UserMapper
  
    An interface to use for transform User instances into array and viceversa.
  
- Persistence

  - Transaction

    An interface to use for transaction cross Bounded Contexts.
  
- Use Cases

  - UseCase
    
    An interface to use for isolate the use case from the request (CLI,HTTP...).
    
  - Error
  
    - Error
    
      A representation of a generic error in the domain. The error it will be specified using type & code.
      
    - AbstractError
    
      An abstract implementation of ErrorInterface.
    
    - ErrorType
    
      An interface that extends Enum, used for specify all the error type of your domain.
      
    - AbstractErrorType
    
      An implementation of ErrorType.
    
  - Request
  
    - Request
    
      An interface used as DTO for pass data from the infrastructure/application to the domain.
    
    - CollectionRequest
    
      An implementation of the Request using Collection.
    
  - Response
  
    - Response
    
      An interface used for pass data from the domain to the infrastructure/application, it uses two main properties
      Errors: pass all "errors"
      Data:  pass all other "data/information"
      
    - CollectionResponse
    
      An implementation of Response using Collection. 
      
    
  - Validation
  
    - ValidableRequest
    
      An interface used for the validate request's data inside the self request
    
    - ValidableUseCase

      An interface used for the validate request's data inside the UseCase
      
## A Practical Example

- [Slim](https://github.com/damianopetrungaro/clean-architecture/tree/master/examples/slim)

  This is a simple example of a TODO list of users, using slim microframework and clean architecture package.
  For any doubt or info add an issue.
