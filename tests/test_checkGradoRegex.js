const { expect } = require("chai");
const reconocerTitulacion = require("../scripts/checkGradoRegex"); // Replace with the actual path to your file

describe("reconocerTitulacion", () => {
    it("should recognize 'dgiim'", () => {
        expect(reconocerTitulacion("ingenieria informatica y matematicas")).to.equal("dgiim");
    });

    it("should recognize 'dgiiade'", () => {
        expect(reconocerTitulacion("ingenieria informatica y administracion y direccion de empresas")).to.equal("dgiiade");
    });

    it("should recognize 'informatica'", () => {
        expect(reconocerTitulacion("Informatica")).to.equal("informatica");
    });

    it("should recognize 'teleco'", () => {
        expect(reconocerTitulacion("Ingenieria de Tecnologias de Telecomunicaciones")).to.equal("teleco");
    });

    it("should recognize 'ade'", () => {
        expect(reconocerTitulacion("ADE")).to.equal("ade");
    });

    it("should recognize 'error'", () => {
        expect(reconocerTitulacion("Some random text")).to.equal("error");
    });
});
