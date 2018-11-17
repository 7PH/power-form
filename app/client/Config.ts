
export interface Config {

    elements: ConfigElement[];
}

export interface ConfigElement {

    type: string;

    title: string;

    default: string | boolean | number;
}