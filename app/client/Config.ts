
export interface Config {

    FORM_ELEMENTS: ConfigElement[];
}

export interface ConfigElement {

    type: string;

    title: string;

    default: string | boolean | number;
}