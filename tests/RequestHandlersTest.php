<?php

use App\RequestHandler\RequestHandlerFactory;
use App\RequestHandler\GooglePlacesNearByHandler;
use App\Helper\GPArgumentRewriter;
use App\Exceptions\NoHandlerAvailableException;

class TestRequestHandlers extends MSWTestCase {

    public function setUp(): void {
        RequestHandlerFactory::configureFactory($this->getConfig());
    }

    public function testConfig() {
        $this->assertCount(1,$this->getConfig()->search_engines);
        $this->assertEquals($this->getConfig()->search_engines[0]->handler, "App\\RequestHandler\\GooglePlacesNearByHandler");
    }

    public function testDefaultHandler() {
        $this->assertInstanceOf(
            GooglePlacesNearByHandler::class,
            RequestHandlerFactory::getRequestHandler("gpnb")
        );
    }

    public function testArgumentRewriterAndDefaults() {
        $this->assertInstanceOf(
            GPArgumentRewriter::class,
            RequestHandlerFactory::getRequestHandler("gpnb")->getArgumentRewriter()
        );
        $handler = RequestHandlerFactory::getRequestHandler("gpnb");
        $rewritten = $handler->getArgumentRewriter()->rewrite(
            $this->getConfig()->search_engines[0]->api_key, $this->getConfig()->param_delim,
            $handler->getDefaults(), 
            "Petworth,UK"
        );
        $this->assertEquals(["50.9867009,-0.6107242",1000, "surf", "lodging"], $rewritten);

        $rewritten = $handler->getArgumentRewriter()->rewrite(
            $this->getConfig()->search_engines[0]->api_key, $this->getConfig()->param_delim,
            $handler->getDefaults(), 
            "Petworth,UK|2000"
        );
        $this->assertEquals(["50.9867009,-0.6107242",2000, "surf", "lodging"], $rewritten);

        $rewritten = $handler->getArgumentRewriter()->rewrite(
            $this->getConfig()->search_engines[0]->api_key, $this->getConfig()->param_delim,
            $handler->getDefaults(), 
            "Petworth,UK|2000|take out"
        );
        $this->assertEquals(["50.9867009,-0.6107242", "2000", "take out", "lodging"], $rewritten);

        $rewritten = $handler->getArgumentRewriter()->rewrite(
            $this->getConfig()->search_engines[0]->api_key, $this->getConfig()->param_delim,
            $handler->getDefaults(), 
            "Petworth,UK|2000|take out|food"
        );
        $this->assertEquals(["50.9867009,-0.6107242",2000, "take out", "food"], $rewritten);

    }

    public function testNoMatchingHandler() {
        $this->expectException(NoHandlerAvailableException::class);

        $this->assertFalse(RequestHandlerFactory::getRequestHandler("gpnb2"));
    }
}