/**
 * One element in the form
 */
import {Icon} from "./Icon";

export interface ConfigElement {

    type: "separator" | "checkbox" | "input" | "textarea";

    title: string;

    icon: Icon;
}

/**
 * A separator
 */
export interface Separator extends ConfigElement {

    type: "separator";
}

/**
 * A checkbox
 */
export interface CheckboxElement extends ConfigElement {

    type: "checkbox";

    default: boolean;
}

/**
 * An input
 */
export interface InputElement extends ConfigElement {

    type: "input";

    default: string;
}

/**
 * A text area
 *
 * @TODO handle number of cols & rows
 */
export interface TextAreaElement extends ConfigElement {

    type: "textarea";

    default: string;
}