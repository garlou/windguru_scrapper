var casper = require('casper').create({
        verbose: true,
        logLevel: 'debug',
        pageSettings: {
            loadImages: true, // The WebPage instance used by Casper will
            loadPlugins: false, // use these settings
            userAgent: 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.4 (KHTML, like Gecko) Chrome/22.0.1229.94 Safari/537.4'
        }
    }),
    system = require('system'),
    //link = 'http://www.windguru.cz/pt/index.php?sc=48963',
    links = [
    {
        name: 'Costa-da-Caparica',
        link: 'http://www.windguru.cz/pt/index.php?sc=48963',
        frame: {
            top: 256,
            left: 142,
            width: 1024,
            height: 300
        }
    }];

// print out all the messages in the headless browser context
casper.on('remote.message', function(msg) {
    this.echo('remote message caught: ' + msg);
});

// print out all the messages in the headless browser context
casper.on("page.error", function(msg, trace) {
    this.echo("Page Error: " + msg, "ERROR");
});


for (var i in links) {

    casper.start(links[i].link, function() {
        this.echo(this.getTitle());
        this.capture('captures/windguru_' + links[i].name + '_' + Date.now() + '.png', links[i].frame);
    });

    casper.run();
}