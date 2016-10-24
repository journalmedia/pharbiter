# Pharbiter

CLI tool for checking if the contracts of test doubles have been implemented.

## Current Capabilities

The `pharb check` command can check a single test method. It will output any
method calls to [Prophecy doubles](https://github.com/phpspec/prophecy) that
are not annotated with a contract test. It can only process doubles created
with a fully qualified class name.

The contract test annotation format is as follows:

```
/** @contract DoubledObjectTest::test_for_method_call */
```

## Acceptance Test Cases

* Single test, single double, without annotation
* Single test, single double, contract not fulfilled
* Single test, single double, contract fulfilled
* Single test, multiple doubles
* Multiple tests
* Multiple test cases
