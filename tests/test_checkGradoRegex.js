const { expect } = require("chai");
const reconocerTitulacion = require("./your-file-name"); // Replace with the actual path to your file

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

    it("should recognize 'error' for random text", () => {
        expect(reconocerTitulacion("Some random text")).to.equal("error");
    });

    it("should recognize 'teleco' for mixed case", () => {
        expect(reconocerTitulacion("InGenIeRIA de TecNOlogias De telecoMUNICACIONes")).to.equal("teleco");
    });

    it("should recognize 'informatica' for variations", () => {
        expect(reconocerTitulacion("ingenieria en Informatica")).to.equal("informatica");
    });

    it("should recognize 'dgiiade' for variations", () => {
        expect(reconocerTitulacion("Doble Grado en Ingenieria Informatica y ADE")).to.equal("dgiiade");
    });

    it("should recognize 'dgiim' for variations", () => {
        expect(reconocerTitulacion("Grado en Informatica y Matematicas")).to.equal("dgiim");
    });
});
