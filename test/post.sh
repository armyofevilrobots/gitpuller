#!/bin/bash
curl -H "Content-Type: application/json" -X POST --raw --data-binary @../data/test.post http://localhost/gitphp/
