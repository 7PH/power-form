/**
 * Utility functions for the form dynamic generation
 */




type Config = any;



async function loadConfig(): Promise<Config> {

    return (await fetch('./config.json')).json();
}