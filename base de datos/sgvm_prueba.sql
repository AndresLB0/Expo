--
-- PostgreSQL database dump
--

-- Dumped from database version 14.5
-- Dumped by pg_dump version 14.2

-- Started on 2022-10-01 22:22:26

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- TOC entry 209 (class 1259 OID 16763)
-- Name: cargo; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.cargo (
    id_cargo integer NOT NULL,
    nombre_cargo character varying(30)
);


ALTER TABLE public.cargo OWNER TO postgres;

--
-- TOC entry 210 (class 1259 OID 16766)
-- Name: cargo_id_cargo_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.cargo_id_cargo_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.cargo_id_cargo_seq OWNER TO postgres;

--
-- TOC entry 3469 (class 0 OID 0)
-- Dependencies: 210
-- Name: cargo_id_cargo_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.cargo_id_cargo_seq OWNED BY public.cargo.id_cargo;


--
-- TOC entry 211 (class 1259 OID 16767)
-- Name: cliente; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.cliente (
    id_cliente integer NOT NULL,
    nombre character varying(50),
    autoridnm character varying(17),
    nacimiento date,
    nombre_cont character varying(50),
    horario character varying(50),
    direccion character varying(200),
    dui character varying(9),
    nit character varying(14),
    nrc character varying(40),
    mont_maxvent integer,
    desc_auto integer,
    nojunta character varying(17),
    id_especi integer NOT NULL,
    id_insti integer NOT NULL
);


ALTER TABLE public.cliente OWNER TO postgres;

--
-- TOC entry 212 (class 1259 OID 16770)
-- Name: cliente_id_cliente_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.cliente_id_cliente_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.cliente_id_cliente_seq OWNER TO postgres;

--
-- TOC entry 3470 (class 0 OID 0)
-- Dependencies: 212
-- Name: cliente_id_cliente_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.cliente_id_cliente_seq OWNED BY public.cliente.id_cliente;


--
-- TOC entry 213 (class 1259 OID 16771)
-- Name: detalle_pedido; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.detalle_pedido (
    id_detapedi integer NOT NULL,
    precio numeric(4,0),
    cantidad integer,
    id_producto integer NOT NULL,
    id_pedidos integer NOT NULL
);


ALTER TABLE public.detalle_pedido OWNER TO postgres;

--
-- TOC entry 214 (class 1259 OID 16774)
-- Name: detalle_pedido_id_detapedi_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.detalle_pedido_id_detapedi_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.detalle_pedido_id_detapedi_seq OWNER TO postgres;

--
-- TOC entry 3471 (class 0 OID 0)
-- Dependencies: 214
-- Name: detalle_pedido_id_detapedi_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.detalle_pedido_id_detapedi_seq OWNED BY public.detalle_pedido.id_detapedi;


--
-- TOC entry 215 (class 1259 OID 16775)
-- Name: envio; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.envio (
    id_envio integer NOT NULL,
    tipo character varying(30)
);


ALTER TABLE public.envio OWNER TO postgres;

--
-- TOC entry 216 (class 1259 OID 16778)
-- Name: envio_id_envio_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.envio_id_envio_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.envio_id_envio_seq OWNER TO postgres;

--
-- TOC entry 3472 (class 0 OID 0)
-- Dependencies: 216
-- Name: envio_id_envio_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.envio_id_envio_seq OWNED BY public.envio.id_envio;


--
-- TOC entry 217 (class 1259 OID 16779)
-- Name: especialidad; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.especialidad (
    id_especi integer NOT NULL,
    nombre character varying(50)
);


ALTER TABLE public.especialidad OWNER TO postgres;

--
-- TOC entry 218 (class 1259 OID 16782)
-- Name: especialidad_id_especi_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.especialidad_id_especi_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.especialidad_id_especi_seq OWNER TO postgres;

--
-- TOC entry 3473 (class 0 OID 0)
-- Dependencies: 218
-- Name: especialidad_id_especi_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.especialidad_id_especi_seq OWNED BY public.especialidad.id_especi;


--
-- TOC entry 219 (class 1259 OID 16783)
-- Name: institucion; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.institucion (
    id_insti integer NOT NULL,
    tipo_insti character varying(50) NOT NULL
);


ALTER TABLE public.institucion OWNER TO postgres;

--
-- TOC entry 220 (class 1259 OID 16786)
-- Name: institucion_id_insti_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.institucion_id_insti_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.institucion_id_insti_seq OWNER TO postgres;

--
-- TOC entry 3474 (class 0 OID 0)
-- Dependencies: 220
-- Name: institucion_id_insti_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.institucion_id_insti_seq OWNED BY public.institucion.id_insti;


--
-- TOC entry 221 (class 1259 OID 16787)
-- Name: linea; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.linea (
    id_linea integer NOT NULL,
    nombre_linea character varying(50)
);


ALTER TABLE public.linea OWNER TO postgres;

--
-- TOC entry 222 (class 1259 OID 16790)
-- Name: linea_id_linea_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.linea_id_linea_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.linea_id_linea_seq OWNER TO postgres;

--
-- TOC entry 3475 (class 0 OID 0)
-- Dependencies: 222
-- Name: linea_id_linea_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.linea_id_linea_seq OWNED BY public.linea.id_linea;


--
-- TOC entry 223 (class 1259 OID 16791)
-- Name: lote; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.lote (
    id_lote integer NOT NULL,
    lote character varying(7),
    vence date,
    cantidad integer,
    id_producto integer NOT NULL
);


ALTER TABLE public.lote OWNER TO postgres;

--
-- TOC entry 224 (class 1259 OID 16794)
-- Name: lote_id_lote_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.lote_id_lote_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.lote_id_lote_seq OWNER TO postgres;

--
-- TOC entry 3476 (class 0 OID 0)
-- Dependencies: 224
-- Name: lote_id_lote_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.lote_id_lote_seq OWNED BY public.lote.id_lote;


--
-- TOC entry 225 (class 1259 OID 16795)
-- Name: pedidos; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.pedidos (
    id_pedidos integer NOT NULL,
    fecha date,
    hora time without time zone,
    tiempo_credi character varying(30),
    total_pagar numeric(6,0),
    fecha_pago date,
    id_personal integer NOT NULL,
    id_tipofact integer NOT NULL,
    id_envio integer NOT NULL,
    id_cliente integer NOT NULL,
    id_zona integer NOT NULL,
    estado_pedido smallint DEFAULT 0 NOT NULL
);


ALTER TABLE public.pedidos OWNER TO postgres;

--
-- TOC entry 226 (class 1259 OID 16799)
-- Name: pedidos_id_pedidos_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.pedidos_id_pedidos_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.pedidos_id_pedidos_seq OWNER TO postgres;

--
-- TOC entry 3477 (class 0 OID 0)
-- Dependencies: 226
-- Name: pedidos_id_pedidos_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.pedidos_id_pedidos_seq OWNED BY public.pedidos.id_pedidos;


--
-- TOC entry 227 (class 1259 OID 16800)
-- Name: personal; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.personal (
    id_personal integer NOT NULL,
    nombre character varying(50),
    dui character varying(9),
    telefono numeric(8,0),
    direccion character varying(200),
    usuario character varying(50),
    clave character varying(100),
    id_cargo integer NOT NULL,
    token character varying
);


ALTER TABLE public.personal OWNER TO postgres;

--
-- TOC entry 228 (class 1259 OID 16803)
-- Name: personal_id_personal_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.personal_id_personal_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.personal_id_personal_seq OWNER TO postgres;

--
-- TOC entry 3478 (class 0 OID 0)
-- Dependencies: 228
-- Name: personal_id_personal_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.personal_id_personal_seq OWNED BY public.personal.id_personal;


--
-- TOC entry 229 (class 1259 OID 16804)
-- Name: presentacion; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.presentacion (
    id_presentacion integer NOT NULL,
    presentacio character varying(100)
);


ALTER TABLE public.presentacion OWNER TO postgres;

--
-- TOC entry 230 (class 1259 OID 16807)
-- Name: presentacion_id_presentacion_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.presentacion_id_presentacion_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.presentacion_id_presentacion_seq OWNER TO postgres;

--
-- TOC entry 3479 (class 0 OID 0)
-- Dependencies: 230
-- Name: presentacion_id_presentacion_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.presentacion_id_presentacion_seq OWNED BY public.presentacion.id_presentacion;


--
-- TOC entry 231 (class 1259 OID 16808)
-- Name: producto; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.producto (
    id_producto integer NOT NULL,
    nombre_producto character varying(50),
    descripcion character varying(150),
    reg_san character varying(14),
    tamanio character varying(30) NOT NULL,
    precio_fact numeric(4,2),
    precio_iva numeric(4,2),
    max_descuento integer,
    existencias integer,
    id_provee integer NOT NULL,
    id_linea integer NOT NULL,
    id_presentacion integer NOT NULL,
    estado_producto smallint DEFAULT 0 NOT NULL
);


ALTER TABLE public.producto OWNER TO postgres;

--
-- TOC entry 232 (class 1259 OID 16812)
-- Name: producto_id_producto_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.producto_id_producto_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.producto_id_producto_seq OWNER TO postgres;

--
-- TOC entry 3480 (class 0 OID 0)
-- Dependencies: 232
-- Name: producto_id_producto_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.producto_id_producto_seq OWNED BY public.producto.id_producto;


--
-- TOC entry 233 (class 1259 OID 16813)
-- Name: proveedor; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.proveedor (
    id_provee integer NOT NULL,
    nombre character varying(50),
    nombre_contacto character varying(25),
    telefono integer
);


ALTER TABLE public.proveedor OWNER TO postgres;

--
-- TOC entry 234 (class 1259 OID 16816)
-- Name: proveedor_id_provee_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.proveedor_id_provee_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.proveedor_id_provee_seq OWNER TO postgres;

--
-- TOC entry 3481 (class 0 OID 0)
-- Dependencies: 234
-- Name: proveedor_id_provee_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.proveedor_id_provee_seq OWNED BY public.proveedor.id_provee;


--
-- TOC entry 235 (class 1259 OID 16817)
-- Name: tipo_fact; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tipo_fact (
    id_tipofact integer NOT NULL,
    nombre character varying(30)
);


ALTER TABLE public.tipo_fact OWNER TO postgres;

--
-- TOC entry 236 (class 1259 OID 16820)
-- Name: tipo_fact_id_tipofact_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tipo_fact_id_tipofact_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tipo_fact_id_tipofact_seq OWNER TO postgres;

--
-- TOC entry 3482 (class 0 OID 0)
-- Dependencies: 236
-- Name: tipo_fact_id_tipofact_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tipo_fact_id_tipofact_seq OWNED BY public.tipo_fact.id_tipofact;


--
-- TOC entry 237 (class 1259 OID 16821)
-- Name: zona; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.zona (
    id_zona integer NOT NULL,
    nombre_zona character varying(30)
);


ALTER TABLE public.zona OWNER TO postgres;

--
-- TOC entry 238 (class 1259 OID 16824)
-- Name: zona_id_zona_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.zona_id_zona_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.zona_id_zona_seq OWNER TO postgres;

--
-- TOC entry 3483 (class 0 OID 0)
-- Dependencies: 238
-- Name: zona_id_zona_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.zona_id_zona_seq OWNED BY public.zona.id_zona;


--
-- TOC entry 3234 (class 2604 OID 16825)
-- Name: cargo id_cargo; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.cargo ALTER COLUMN id_cargo SET DEFAULT nextval('public.cargo_id_cargo_seq'::regclass);


--
-- TOC entry 3235 (class 2604 OID 16826)
-- Name: cliente id_cliente; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.cliente ALTER COLUMN id_cliente SET DEFAULT nextval('public.cliente_id_cliente_seq'::regclass);


--
-- TOC entry 3236 (class 2604 OID 16827)
-- Name: detalle_pedido id_detapedi; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.detalle_pedido ALTER COLUMN id_detapedi SET DEFAULT nextval('public.detalle_pedido_id_detapedi_seq'::regclass);


--
-- TOC entry 3237 (class 2604 OID 16828)
-- Name: envio id_envio; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.envio ALTER COLUMN id_envio SET DEFAULT nextval('public.envio_id_envio_seq'::regclass);


--
-- TOC entry 3238 (class 2604 OID 16829)
-- Name: especialidad id_especi; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.especialidad ALTER COLUMN id_especi SET DEFAULT nextval('public.especialidad_id_especi_seq'::regclass);


--
-- TOC entry 3239 (class 2604 OID 16830)
-- Name: institucion id_insti; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.institucion ALTER COLUMN id_insti SET DEFAULT nextval('public.institucion_id_insti_seq'::regclass);


--
-- TOC entry 3240 (class 2604 OID 16831)
-- Name: linea id_linea; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.linea ALTER COLUMN id_linea SET DEFAULT nextval('public.linea_id_linea_seq'::regclass);


--
-- TOC entry 3241 (class 2604 OID 16832)
-- Name: lote id_lote; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.lote ALTER COLUMN id_lote SET DEFAULT nextval('public.lote_id_lote_seq'::regclass);


--
-- TOC entry 3243 (class 2604 OID 16833)
-- Name: pedidos id_pedidos; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.pedidos ALTER COLUMN id_pedidos SET DEFAULT nextval('public.pedidos_id_pedidos_seq'::regclass);


--
-- TOC entry 3244 (class 2604 OID 16834)
-- Name: personal id_personal; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.personal ALTER COLUMN id_personal SET DEFAULT nextval('public.personal_id_personal_seq'::regclass);


--
-- TOC entry 3245 (class 2604 OID 16835)
-- Name: presentacion id_presentacion; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.presentacion ALTER COLUMN id_presentacion SET DEFAULT nextval('public.presentacion_id_presentacion_seq'::regclass);


--
-- TOC entry 3247 (class 2604 OID 16836)
-- Name: producto id_producto; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.producto ALTER COLUMN id_producto SET DEFAULT nextval('public.producto_id_producto_seq'::regclass);


--
-- TOC entry 3248 (class 2604 OID 16837)
-- Name: proveedor id_provee; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.proveedor ALTER COLUMN id_provee SET DEFAULT nextval('public.proveedor_id_provee_seq'::regclass);


--
-- TOC entry 3249 (class 2604 OID 16838)
-- Name: tipo_fact id_tipofact; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tipo_fact ALTER COLUMN id_tipofact SET DEFAULT nextval('public.tipo_fact_id_tipofact_seq'::regclass);


--
-- TOC entry 3250 (class 2604 OID 16839)
-- Name: zona id_zona; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.zona ALTER COLUMN id_zona SET DEFAULT nextval('public.zona_id_zona_seq'::regclass);


--
-- TOC entry 3434 (class 0 OID 16763)
-- Dependencies: 209
-- Data for Name: cargo; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.cargo (id_cargo, nombre_cargo) VALUES (1, 'gerente');
INSERT INTO public.cargo (id_cargo, nombre_cargo) VALUES (2, 'visitador');
INSERT INTO public.cargo (id_cargo, nombre_cargo) VALUES (3, 'vendedor');
INSERT INTO public.cargo (id_cargo, nombre_cargo) VALUES (4, 'facturacion');


--
-- TOC entry 3436 (class 0 OID 16767)
-- Dependencies: 211
-- Data for Name: cliente; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.cliente (id_cliente, nombre, autoridnm, nacimiento, nombre_cont, horario, direccion, dui, nit, nrc, mont_maxvent, desc_auto, nojunta, id_especi, id_insti) VALUES (6, 'Farmacia Popular', NULL, NULL, 'Dalia Maria de Cordova', '8:00 Am a 6:00 PM', '2A. Calle Oriente #7 Soyapango', NULL, '06140512430034', '21583-0', NULL, NULL, NULL, 5, 2);
INSERT INTO public.cliente (id_cliente, nombre, autoridnm, nacimiento, nombre_cont, horario, direccion, dui, nit, nrc, mont_maxvent, desc_auto, nojunta, id_especi, id_insti) VALUES (5, 'Farmacia San Antonio', NULL, NULL, 'J.D.P Espinoza', '7:00 Am a 12:00 PM', 'Av. 3 de Abril, #28 Barrio Santa Teresa, Armenia', NULL, '03151806650017', '99621-1', NULL, NULL, NULL, 5, 2);
INSERT INTO public.cliente (id_cliente, nombre, autoridnm, nacimiento, nombre_cont, horario, direccion, dui, nit, nrc, mont_maxvent, desc_auto, nojunta, id_especi, id_insti) VALUES (4, 'Dra. Veronica Salomon', NULL, '1977-04-03', 'Dra. Veronica Salomon', '6:00 Am a 4:00 PM', 'Ciudad Versailles centro comercial Campos Eliseos local #12-b, San Juan Opico', '035743010', '05121311851034', NULL, NULL, NULL, NULL, 1, 8);
INSERT INTO public.cliente (id_cliente, nombre, autoridnm, nacimiento, nombre_cont, horario, direccion, dui, nit, nrc, mont_maxvent, desc_auto, nojunta, id_especi, id_insti) VALUES (3, 'Dra. Jennifer Massiell Iriondo Pilia', NULL, '1996-11-07', 'Dra. Jennifer Massiell Iriondo Pilia', '8:00 Am a 10:00 PM', 'Colonia Guadalupe  PL GLT5 CL, San Luis, Ataquizalla', '018951257', '03151504831018', NULL, NULL, NULL, NULL, 2, 8);
INSERT INTO public.cliente (id_cliente, nombre, autoridnm, nacimiento, nombre_cont, horario, direccion, dui, nit, nrc, mont_maxvent, desc_auto, nojunta, id_especi, id_insti) VALUES (2, 'Dr. Edwin Ernesto Umaña Ramirez', NULL, '1985-02-12', 'Dr. Edwin Ernesto Unaña Ramirez', '7:00 Am a 7:00 PM', 'Residencial Florencia Av. El carrizo, Poligono H, Casa N°1, Santa Ana', '020284064', '02101109781140', NULL, NULL, NULL, NULL, 2, 8);
INSERT INTO public.cliente (id_cliente, nombre, autoridnm, nacimiento, nombre_cont, horario, direccion, dui, nit, nrc, mont_maxvent, desc_auto, nojunta, id_especi, id_insti) VALUES (1, 'Farmacia San Juan', NULL, NULL, 'Rina Yesenia Duarte de Flores', '7:00 Am a 7:00 PM', 'Avenida Belen Norte, Barrio San Esteban, Texistepeque frente al parque', NULL, '02131904771010', '143465-9', NULL, NULL, NULL, 5, 2);


--
-- TOC entry 3438 (class 0 OID 16771)
-- Dependencies: 213
-- Data for Name: detalle_pedido; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.detalle_pedido (id_detapedi, precio, cantidad, id_producto, id_pedidos) VALUES (1, 145, 2, 2, 3);
INSERT INTO public.detalle_pedido (id_detapedi, precio, cantidad, id_producto, id_pedidos) VALUES (2, 75, 1, 1, 4);
INSERT INTO public.detalle_pedido (id_detapedi, precio, cantidad, id_producto, id_pedidos) VALUES (3, 45, 1, 2, 1);
INSERT INTO public.detalle_pedido (id_detapedi, precio, cantidad, id_producto, id_pedidos) VALUES (4, 83, 2, 4, 4);
INSERT INTO public.detalle_pedido (id_detapedi, precio, cantidad, id_producto, id_pedidos) VALUES (5, 43, 3, 3, 1);


--
-- TOC entry 3440 (class 0 OID 16775)
-- Dependencies: 215
-- Data for Name: envio; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.envio (id_envio, tipo) VALUES (1, 'visitador
');
INSERT INTO public.envio (id_envio, tipo) VALUES (2, 'transporte');


--
-- TOC entry 3442 (class 0 OID 16779)
-- Dependencies: 217
-- Data for Name: especialidad; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.especialidad (id_especi, nombre) VALUES (1, 'ginecologia');
INSERT INTO public.especialidad (id_especi, nombre) VALUES (2, 'pediatria');
INSERT INTO public.especialidad (id_especi, nombre) VALUES (3, 'medicina familiar');
INSERT INTO public.especialidad (id_especi, nombre) VALUES (4, 'medicina general');
INSERT INTO public.especialidad (id_especi, nombre) VALUES (5, 'no aplica');


--
-- TOC entry 3444 (class 0 OID 16783)
-- Dependencies: 219
-- Data for Name: institucion; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.institucion (id_insti, tipo_insti) VALUES (1, 'clinica parroquial');
INSERT INTO public.institucion (id_insti, tipo_insti) VALUES (2, 'farmacia');
INSERT INTO public.institucion (id_insti, tipo_insti) VALUES (3, 'botiquin medico');
INSERT INTO public.institucion (id_insti, tipo_insti) VALUES (4, 'farmacia empresarial');
INSERT INTO public.institucion (id_insti, tipo_insti) VALUES (5, 'hospital');
INSERT INTO public.institucion (id_insti, tipo_insti) VALUES (6, 'ONG');
INSERT INTO public.institucion (id_insti, tipo_insti) VALUES (7, 'drogueria');
INSERT INTO public.institucion (id_insti, tipo_insti) VALUES (8, 'no aplica');


--
-- TOC entry 3446 (class 0 OID 16787)
-- Dependencies: 221
-- Data for Name: linea; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.linea (id_linea, nombre_linea) VALUES (1, 'faes');
INSERT INTO public.linea (id_linea, nombre_linea) VALUES (2, 'mefasa
');
INSERT INTO public.linea (id_linea, nombre_linea) VALUES (3, 'biocodex');
INSERT INTO public.linea (id_linea, nombre_linea) VALUES (4, 'atral');
INSERT INTO public.linea (id_linea, nombre_linea) VALUES (5, 'angeline');
INSERT INTO public.linea (id_linea, nombre_linea) VALUES (6, 'heidelg pharrma');


--
-- TOC entry 3448 (class 0 OID 16791)
-- Dependencies: 223
-- Data for Name: lote; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.lote (id_lote, lote, vence, cantidad, id_producto) VALUES (1, '0907229', '2022-09-07', 5, 3);
INSERT INTO public.lote (id_lote, lote, vence, cantidad, id_producto) VALUES (2, '0305225', '2022-03-05', 7, 2);


--
-- TOC entry 3450 (class 0 OID 16795)
-- Dependencies: 225
-- Data for Name: pedidos; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.pedidos (id_pedidos, fecha, hora, tiempo_credi, total_pagar, fecha_pago, id_personal, id_tipofact, id_envio, id_cliente, id_zona, estado_pedido) VALUES (1, '2022-05-02', '10:36:00', 'a contado', 49, '2022-05-12', 1, 2, 2, 4, 3, 0);
INSERT INTO public.pedidos (id_pedidos, fecha, hora, tiempo_credi, total_pagar, fecha_pago, id_personal, id_tipofact, id_envio, id_cliente, id_zona, estado_pedido) VALUES (2, '2022-03-12', '16:32:00', '15 dias', 78, '2022-05-27', 4, 1, 2, 3, 4, 0);
INSERT INTO public.pedidos (id_pedidos, fecha, hora, tiempo_credi, total_pagar, fecha_pago, id_personal, id_tipofact, id_envio, id_cliente, id_zona, estado_pedido) VALUES (3, '2022-01-07', '11:02:00', '30 dias ', 45, '2022-01-07', 1, 1, 1, 2, 2, 0);
INSERT INTO public.pedidos (id_pedidos, fecha, hora, tiempo_credi, total_pagar, fecha_pago, id_personal, id_tipofact, id_envio, id_cliente, id_zona, estado_pedido) VALUES (4, '2022-03-12', '09:14:00', 'a contado', 27, '2022-03-12', 3, 2, 2, 4, 1, 0);
INSERT INTO public.pedidos (id_pedidos, fecha, hora, tiempo_credi, total_pagar, fecha_pago, id_personal, id_tipofact, id_envio, id_cliente, id_zona, estado_pedido) VALUES (5, '2022-02-05', '15:21:00', 'a contado', 57, '2022-02-05', 1, 1, 2, 3, 2, 0);


--
-- TOC entry 3452 (class 0 OID 16800)
-- Dependencies: 227
-- Data for Name: personal; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.personal (id_personal, nombre, dui, telefono, direccion, usuario, clave, id_cargo, token) VALUES (1, 'Silvia Carolina Cardona Garzona', '021168229', 77409724, 'Urbanizacion Cumbres de Cuscatlan Calle Metzi #34, Antiguo Cuscatlan', 'SilvCarol', 'SilviaCarolina7', 3, NULL);
INSERT INTO public.personal (id_personal, nombre, dui, telefono, direccion, usuario, clave, id_cargo, token) VALUES (2, 'Mirna Elizabeth Perez de Romero', '035055048', 22403635, 'Colonia El Conacaste Pasaje 3, casa 19', 'MirnaRomero', 'MirnaRomero7', 4, NULL);
INSERT INTO public.personal (id_personal, nombre, dui, telefono, direccion, usuario, clave, id_cargo, token) VALUES (3, 'Jose Gabriel Garcia Hernandez', '000680622', 77403767, 'Urbanizacion La Santisima Trinidad Poligono 2, Pasaje 1, Bk H#26', 'JoGabo', 'Gabo7', 3, NULL);
INSERT INTO public.personal (id_personal, nombre, dui, telefono, direccion, usuario, clave, id_cargo, token) VALUES (4, 'Georgina Patricia Folres de Benitez', '016737526', 75122541, '13 calle oriente, pol. E, Casa #17, Residencial Arcos de San Francisco', 'Georgina7', 'GoerginaPaty', 3, NULL);
INSERT INTO public.personal (id_personal, nombre, dui, telefono, direccion, usuario, clave, id_cargo, token) VALUES (5, 'Nelson Alfredo Pineda Cruz', '000489814', 75164011, 'Residencial San Ramon de los Altos, senda 5 poligono B.#15', 'NelFredo', 'Nelson77', 1, NULL);
INSERT INTO public.personal (id_personal, nombre, dui, telefono, direccion, usuario, clave, id_cargo, token) VALUES (6, 'Jennifer Maria Borja Orantes', '023208295', 76827137, 'Residencial Ciudad Corinto, #30, senda 8 poniente, block 8 B, mejicanos, San Salvador', 'JennMaria', 'JennMariaOrantes', 1, NULL);
INSERT INTO public.personal (id_personal, nombre, dui, telefono, direccion, usuario, clave, id_cargo, token) VALUES (7, 'marvin', NULL, NULL, NULL, 'Meri', '$2y$10$BijTSwBvtvr1ER1.xGrDvebeGrQ5a.rAYsK3OhVOyUo1YibJMeMIq', 1, NULL);


--
-- TOC entry 3454 (class 0 OID 16804)
-- Dependencies: 229
-- Data for Name: presentacion; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.presentacion (id_presentacion, presentacio) VALUES (1, 'comprimido');
INSERT INTO public.presentacion (id_presentacion, presentacio) VALUES (2, 'ampollas');
INSERT INTO public.presentacion (id_presentacion, presentacio) VALUES (3, 'sobres');
INSERT INTO public.presentacion (id_presentacion, presentacio) VALUES (4, 'ampolletas');
INSERT INTO public.presentacion (id_presentacion, presentacio) VALUES (5, 'grageas');
INSERT INTO public.presentacion (id_presentacion, presentacio) VALUES (6, 'capsulas');
INSERT INTO public.presentacion (id_presentacion, presentacio) VALUES (7, 'gel');
INSERT INTO public.presentacion (id_presentacion, presentacio) VALUES (8, 'masticables');
INSERT INTO public.presentacion (id_presentacion, presentacio) VALUES (9, 'jarabe');
INSERT INTO public.presentacion (id_presentacion, presentacio) VALUES (10, 'inyectable');
INSERT INTO public.presentacion (id_presentacion, presentacio) VALUES (11, 'spray');
INSERT INTO public.presentacion (id_presentacion, presentacio) VALUES (12, 'colutorio');


--
-- TOC entry 3456 (class 0 OID 16808)
-- Dependencies: 231
-- Data for Name: producto; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.producto (id_producto, nombre_producto, descripcion, reg_san, tamanio, precio_fact, precio_iva, max_descuento, existencias, id_provee, id_linea, id_presentacion, estado_producto) VALUES (1, 'bilaxten x10', 'bilastina', NULL, '20mg', 13.00, 15.00, 10, 50, 1, 1, 1, 0);
INSERT INTO public.producto (id_producto, nombre_producto, descripcion, reg_san, tamanio, precio_fact, precio_iva, max_descuento, existencias, id_provee, id_linea, id_presentacion, estado_producto) VALUES (2, 'bilaxten x30', 'bilastina', NULL, '20mg', 40.00, 45.00, NULL, 20, 1, 1, 1, 0);
INSERT INTO public.producto (id_producto, nombre_producto, descripcion, reg_san, tamanio, precio_fact, precio_iva, max_descuento, existencias, id_provee, id_linea, id_presentacion, estado_producto) VALUES (3, 'alerno x10', 'ebastina', NULL, '20mg', 9.00, 11.00, NULL, 30, 1, 2, 1, 0);
INSERT INTO public.producto (id_producto, nombre_producto, descripcion, reg_san, tamanio, precio_fact, precio_iva, max_descuento, existencias, id_provee, id_linea, id_presentacion, estado_producto) VALUES (4, 'rigresan', 'fosfomicina, trometamol', NULL, '3g', 15.00, 17.00, NULL, 40, 1, 2, 3, 0);
INSERT INTO public.producto (id_producto, nombre_producto, descripcion, reg_san, tamanio, precio_fact, precio_iva, max_descuento, existencias, id_provee, id_linea, id_presentacion, estado_producto) VALUES (5, 'stimol', 'malato de citrulina', NULL, '10ml', 19.00, 21.00, NULL, 25, 2, 3, 3, 0);


--
-- TOC entry 3458 (class 0 OID 16813)
-- Dependencies: 233
-- Data for Name: proveedor; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.proveedor (id_provee, nombre, nombre_contacto, telefono) VALUES (1, 'mefasa', NULL, NULL);
INSERT INTO public.proveedor (id_provee, nombre, nombre_contacto, telefono) VALUES (2, 'mercafarma', NULL, NULL);


--
-- TOC entry 3460 (class 0 OID 16817)
-- Dependencies: 235
-- Data for Name: tipo_fact; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.tipo_fact (id_tipofact, nombre) VALUES (1, 'credito fiscal');
INSERT INTO public.tipo_fact (id_tipofact, nombre) VALUES (2, 'consumidor final');


--
-- TOC entry 3462 (class 0 OID 16821)
-- Dependencies: 237
-- Data for Name: zona; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.zona (id_zona, nombre_zona) VALUES (1, 'occidente');
INSERT INTO public.zona (id_zona, nombre_zona) VALUES (2, 'oriente');
INSERT INTO public.zona (id_zona, nombre_zona) VALUES (3, 'central
');
INSERT INTO public.zona (id_zona, nombre_zona) VALUES (4, 'paracentral');


--
-- TOC entry 3484 (class 0 OID 0)
-- Dependencies: 210
-- Name: cargo_id_cargo_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.cargo_id_cargo_seq', 1, false);


--
-- TOC entry 3485 (class 0 OID 0)
-- Dependencies: 212
-- Name: cliente_id_cliente_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.cliente_id_cliente_seq', 1, false);


--
-- TOC entry 3486 (class 0 OID 0)
-- Dependencies: 214
-- Name: detalle_pedido_id_detapedi_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.detalle_pedido_id_detapedi_seq', 1, false);


--
-- TOC entry 3487 (class 0 OID 0)
-- Dependencies: 216
-- Name: envio_id_envio_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.envio_id_envio_seq', 1, false);


--
-- TOC entry 3488 (class 0 OID 0)
-- Dependencies: 218
-- Name: especialidad_id_especi_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.especialidad_id_especi_seq', 1, false);


--
-- TOC entry 3489 (class 0 OID 0)
-- Dependencies: 220
-- Name: institucion_id_insti_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.institucion_id_insti_seq', 1, false);


--
-- TOC entry 3490 (class 0 OID 0)
-- Dependencies: 222
-- Name: linea_id_linea_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.linea_id_linea_seq', 1, false);


--
-- TOC entry 3491 (class 0 OID 0)
-- Dependencies: 224
-- Name: lote_id_lote_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.lote_id_lote_seq', 1, false);


--
-- TOC entry 3492 (class 0 OID 0)
-- Dependencies: 226
-- Name: pedidos_id_pedidos_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.pedidos_id_pedidos_seq', 1, false);


--
-- TOC entry 3493 (class 0 OID 0)
-- Dependencies: 228
-- Name: personal_id_personal_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.personal_id_personal_seq', 1, false);


--
-- TOC entry 3494 (class 0 OID 0)
-- Dependencies: 230
-- Name: presentacion_id_presentacion_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.presentacion_id_presentacion_seq', 1, false);


--
-- TOC entry 3495 (class 0 OID 0)
-- Dependencies: 232
-- Name: producto_id_producto_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.producto_id_producto_seq', 1, false);


--
-- TOC entry 3496 (class 0 OID 0)
-- Dependencies: 234
-- Name: proveedor_id_provee_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.proveedor_id_provee_seq', 1, false);


--
-- TOC entry 3497 (class 0 OID 0)
-- Dependencies: 236
-- Name: tipo_fact_id_tipofact_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tipo_fact_id_tipofact_seq', 1, false);


--
-- TOC entry 3498 (class 0 OID 0)
-- Dependencies: 238
-- Name: zona_id_zona_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.zona_id_zona_seq', 1, false);


--
-- TOC entry 3252 (class 2606 OID 16841)
-- Name: cargo cargo_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.cargo
    ADD CONSTRAINT cargo_pkey PRIMARY KEY (id_cargo);


--
-- TOC entry 3254 (class 2606 OID 16843)
-- Name: cliente cliente_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.cliente
    ADD CONSTRAINT cliente_pkey PRIMARY KEY (id_cliente);


--
-- TOC entry 3256 (class 2606 OID 16845)
-- Name: detalle_pedido detalle_pedido_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.detalle_pedido
    ADD CONSTRAINT detalle_pedido_pkey PRIMARY KEY (id_detapedi);


--
-- TOC entry 3258 (class 2606 OID 16847)
-- Name: envio envio_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.envio
    ADD CONSTRAINT envio_pkey PRIMARY KEY (id_envio);


--
-- TOC entry 3260 (class 2606 OID 16849)
-- Name: especialidad especialidad_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.especialidad
    ADD CONSTRAINT especialidad_pkey PRIMARY KEY (id_especi);


--
-- TOC entry 3262 (class 2606 OID 16851)
-- Name: institucion institucion_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.institucion
    ADD CONSTRAINT institucion_pkey PRIMARY KEY (id_insti);


--
-- TOC entry 3264 (class 2606 OID 16853)
-- Name: linea linea_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.linea
    ADD CONSTRAINT linea_pkey PRIMARY KEY (id_linea);


--
-- TOC entry 3266 (class 2606 OID 16855)
-- Name: lote lote_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.lote
    ADD CONSTRAINT lote_pkey PRIMARY KEY (id_lote);


--
-- TOC entry 3268 (class 2606 OID 16857)
-- Name: pedidos pedidos_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.pedidos
    ADD CONSTRAINT pedidos_pkey PRIMARY KEY (id_pedidos);


--
-- TOC entry 3270 (class 2606 OID 16859)
-- Name: personal personal_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.personal
    ADD CONSTRAINT personal_pkey PRIMARY KEY (id_personal);


--
-- TOC entry 3272 (class 2606 OID 16861)
-- Name: presentacion presentacion_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.presentacion
    ADD CONSTRAINT presentacion_pkey PRIMARY KEY (id_presentacion);


--
-- TOC entry 3274 (class 2606 OID 16863)
-- Name: producto producto_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.producto
    ADD CONSTRAINT producto_pkey PRIMARY KEY (id_producto);


--
-- TOC entry 3276 (class 2606 OID 16865)
-- Name: proveedor proveedor_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.proveedor
    ADD CONSTRAINT proveedor_pkey PRIMARY KEY (id_provee);


--
-- TOC entry 3278 (class 2606 OID 16867)
-- Name: tipo_fact tipo_fact_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tipo_fact
    ADD CONSTRAINT tipo_fact_pkey PRIMARY KEY (id_tipofact);


--
-- TOC entry 3280 (class 2606 OID 16869)
-- Name: zona zona_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.zona
    ADD CONSTRAINT zona_pkey PRIMARY KEY (id_zona);


--
-- TOC entry 3281 (class 2606 OID 16870)
-- Name: cliente cliente_id_especi_especialidad_id_especi; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.cliente
    ADD CONSTRAINT cliente_id_especi_especialidad_id_especi FOREIGN KEY (id_especi) REFERENCES public.especialidad(id_especi);


--
-- TOC entry 3282 (class 2606 OID 16875)
-- Name: cliente cliente_id_insti_institucion_id_insti; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.cliente
    ADD CONSTRAINT cliente_id_insti_institucion_id_insti FOREIGN KEY (id_insti) REFERENCES public.institucion(id_insti);


--
-- TOC entry 3283 (class 2606 OID 16880)
-- Name: detalle_pedido detalle_pedido_id_pedidos_pedidos_id_pedidos; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.detalle_pedido
    ADD CONSTRAINT detalle_pedido_id_pedidos_pedidos_id_pedidos FOREIGN KEY (id_pedidos) REFERENCES public.pedidos(id_pedidos);


--
-- TOC entry 3284 (class 2606 OID 16885)
-- Name: detalle_pedido detalle_pedido_id_producto_producto_id_producto; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.detalle_pedido
    ADD CONSTRAINT detalle_pedido_id_producto_producto_id_producto FOREIGN KEY (id_producto) REFERENCES public.producto(id_producto);


--
-- TOC entry 3285 (class 2606 OID 16890)
-- Name: lote lote_id_producto_producto_id_producto; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.lote
    ADD CONSTRAINT lote_id_producto_producto_id_producto FOREIGN KEY (id_producto) REFERENCES public.producto(id_producto);


--
-- TOC entry 3286 (class 2606 OID 16895)
-- Name: pedidos pedidos_id_cliente_cliente_id_cliente; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.pedidos
    ADD CONSTRAINT pedidos_id_cliente_cliente_id_cliente FOREIGN KEY (id_cliente) REFERENCES public.cliente(id_cliente);


--
-- TOC entry 3287 (class 2606 OID 16900)
-- Name: pedidos pedidos_id_envio_envio_id_envio; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.pedidos
    ADD CONSTRAINT pedidos_id_envio_envio_id_envio FOREIGN KEY (id_envio) REFERENCES public.envio(id_envio);


--
-- TOC entry 3288 (class 2606 OID 16905)
-- Name: pedidos pedidos_id_personal_personal_id_personal; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.pedidos
    ADD CONSTRAINT pedidos_id_personal_personal_id_personal FOREIGN KEY (id_personal) REFERENCES public.personal(id_personal);


--
-- TOC entry 3289 (class 2606 OID 16910)
-- Name: pedidos pedidos_id_tipofact_tipo_fact_id_tipofact; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.pedidos
    ADD CONSTRAINT pedidos_id_tipofact_tipo_fact_id_tipofact FOREIGN KEY (id_tipofact) REFERENCES public.tipo_fact(id_tipofact);


--
-- TOC entry 3290 (class 2606 OID 16915)
-- Name: pedidos pedidos_id_zona_zona_id_zona; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.pedidos
    ADD CONSTRAINT pedidos_id_zona_zona_id_zona FOREIGN KEY (id_zona) REFERENCES public.zona(id_zona);


--
-- TOC entry 3291 (class 2606 OID 16920)
-- Name: personal personal_id_cargo_cargo_id_cargo; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.personal
    ADD CONSTRAINT personal_id_cargo_cargo_id_cargo FOREIGN KEY (id_cargo) REFERENCES public.cargo(id_cargo);


--
-- TOC entry 3292 (class 2606 OID 16925)
-- Name: producto producto_id_linea_linea_id_linea; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.producto
    ADD CONSTRAINT producto_id_linea_linea_id_linea FOREIGN KEY (id_linea) REFERENCES public.linea(id_linea);


--
-- TOC entry 3293 (class 2606 OID 16930)
-- Name: producto producto_id_presentacion_presentacion_id_presentacion; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.producto
    ADD CONSTRAINT producto_id_presentacion_presentacion_id_presentacion FOREIGN KEY (id_presentacion) REFERENCES public.presentacion(id_presentacion);


--
-- TOC entry 3294 (class 2606 OID 16935)
-- Name: producto producto_id_provee_proveedor_id_provee; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.producto
    ADD CONSTRAINT producto_id_provee_proveedor_id_provee FOREIGN KEY (id_provee) REFERENCES public.proveedor(id_provee);


-- Completed on 2022-10-01 22:22:26

--
-- PostgreSQL database dump complete
--

