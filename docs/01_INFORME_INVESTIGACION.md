# Informe 1: Detección de Oportunidades

**Tecnologías de la Información y Ciberseguridad | [cite_start]Inacap** [cite: 434, 435]

* **Nombres:** Bryan Alegría, Diego Aránguiz, Romina Baeza, Elisa Oyarzun y Cristina Sepúlveda [cite: 438]
* [cite_start]**Carrera:** Ingeniería en Informática [cite: 438]
* [cite_start]**Asignatura:** Innovación y emprendimiento [cite: 438]
* **Profesor:** Yaleni Gómez [cite: 438]
* [cite_start]**Fecha:** 15 de abril 2026 [cite: 438]

---

## 1 Introducción
[cite_start]El presente informe documenta la primera fase de la asignatura Innovación y Emprendimiento II, enfocada en la Detección de Oportunidades[cite: 506]. [cite_start]El proyecto consiste en el diseño y validación de una plataforma tipo Marketplace dirigida exclusivamente a los emprendedores de la comuna de Puente Alto[cite: 507]. [cite_start]A nivel tecnológico, la plataforma se desarrolla como un Producto Mínimo Viable (MVP) utilizando WordPress y el plugin Dokan[cite: 508]. [cite_start]Además, opera con una base de datos MySQL, se aloja en Amazon Web Services (AWS) para asegurar la escalabilidad ante el tráfico de usuarios, y se integra con Flow para el procesamiento de pagos, con el fin de eliminar las comisiones por venta[cite: 509]. 

[cite_start]El problema principal identificado radica en que las plataformas de venta tradicionales cobran comisiones elevadas y retienen los pagos, lo que afecta directamente la liquidez de los microemprendores[cite: 510]. [cite_start]A esta situación se suma la brecha digital presente en el segmento de usuarios y la percepción del trámite legal ante el Servicio de Impuestos Internos (SII) como un obstáculo complejo[cite: 511]. [cite_start]Por lo tanto, surge la necesidad de crear un sistema que trascienda la simple comercialización, ofreciendo una interfaz de fácil uso, acompañamiento en el proceso de formalización y la entrega inmediata de los ingresos generados[cite: 512].

---

## 2 Cuestionario y Guion de Entrevista
[cite_start]El guion está diseñado para entender el funcionamiento del Marketplace, sin proponer soluciones iniciales[cite: 534]. 

| Tipo | Pregunta | Objetivo / Qué Anotar | Cita Clave / Insight |
| :--- | :--- | :--- | :--- |
| **Operacional** | [cite_start]¿Cuando un emprendedor quiere participar en el Marketplace, cómo es el proceso desde que se registra hasta que puede publicar su primer producto? [cite: 539] | [cite_start]Entender el flujo completo de incorporación de un vendedor y detectar posibles fricciones en el proceso. [cite: 539] | [cite_start]Se verifica que estén formalizados como empresa real ante el SII y se realiza una entrevista previa. [cite: 539] |
| **Operacional** | [cite_start]¿Cómo funciona el proceso para publicar y gestionar un producto dentro del Marketplace? [cite: 539] | [cite_start]Comprender cómo se gestionan los productos dentro de la plataforma y si existe algún control de calidad. [cite: 539] | [cite_start]Los productos se ingresan de manera manual y se monitorea que cumplan con los datos mínimos requeridos. [cite: 539] |
| **Pagos** | [cite_start]¿Cómo se manejan los pagos dentro del Marketplace y qué ocurre después de que se confirma uno? [cite: 542] | [cite_start]Comprender el flujo de pagos dentro del sistema y cómo se manejan los casos de error. [cite: 542] | [cite_start]Transacciones mediante Flow, donde el dinero se transfiere directamente a la cuenta del vendedor, ya que el Marketplace no cobra comisiones por venta. [cite: 542] |
| **Modelo de negocio** | [cite_start]¿Cómo está pensado el modelo de negocio del Marketplace? [cite: 542] | [cite_start]Entender la sostenibilidad económica del proyecto. [cite: 542] | [cite_start]Cobraran comisión mensual de 3500 a 4500. [cite: 542] |
| **Historia** | [cite_start]¿Cómo nació la idea del Marketplace y cómo ha evolucionado el proyecto desde que comenzaron? [cite: 544] | [cite_start]Comprender el origen y la evolución del proyecto. [cite: 544] | [cite_start]La idea nace para ayudar a los emprendedores, darles visibilidad en una plataforma centralizada y dar confianza a los posibles clientes. [cite: 544] |
| **Usuarios** | [cite_start]¿Qué tipo de usuarios esperan que utilicen el Marketplace y cómo interactúan entre sí dentro de la plataforma? [cite: 544] | [cite_start]Identificar los actores del sistema y cómo se relacionan dentro del Marketplace. [cite: 544] | [cite_start]Todo emprendedor y cliente que este dentro de la comuna para las entregas. [cite: 544] |
| **Tecnología** | [cite_start]¿Qué tecnologías o herramientas están usando actualmente para desarrollar la plataforma? [cite: 547] | [cite_start]Comprender el contexto tecnológico del proyecto y las decisiones de arquitectura que se han tomado. [cite: 547] | [cite_start]WordPress con el plugin Dokan, base de datos MySQL, AWS como proveedor de hosting y Flow, como pasarela de pagos. [cite: 547] |

---

## 3 Pautas de Entrevista en Profundidad a Experto/Usuario
[cite_start]El objetivo es comprender en profundidad cómo funciona el proyecto de Marketplace, cómo se gestionan los distintos actores dentro de la plataforma y cuáles son los principales desafíos asociados al desarrollo de su arquitectura y funcionamiento[cite: 563].

* [cite_start]**Origen del Proyecto:** Surge con un enfoque principalmente social para apoyar a emprendedores de Puente Alto que enfrentan dificultades para vender en plataformas tradicionales, eliminando el cobro de comisiones por venta y retención de dinero que afecta la liquidez[cite: 574, 707].
* **Usuarios:** Existen tres tipos principales de usuarios: Emprendedor (vendedor), Cliente (comprador) y Superadministrador, con relaciones directas entre cliente y emprendedor para coordinar entregas[cite: 574].
* [cite_start]**Flujo de Venta:** El registro requiere validación de formalización en el SII; la publicación es manual y, al comprar, el sistema registra el pedido, reduce el stock y permite el contacto directo para la entrega[cite: 598, 600, 602, 603, 604, 605, 606, 607].
* [cite_start]**Modelo y Pagos:** Los pagos se realizan a través de Flow sin intermediación financiera del Marketplace, y el modelo se basa en una suscripción mensual (entre $3.500 y $4.500) con tres meses iniciales gratuitos[cite: 610, 611, 612, 614, 615].
* **Desarrollo Técnico:** Se eligió WordPress, Dokan, MySQL y AWS por su rapidez de implementación, bajo costo y facilidad de uso, pero presentan desafíos importantes de escalabilidad y rendimiento ante una proyección de más de 500 usuarios diarios[cite: 630, 631, 632, 634, 635].

---

## 4 Pauta de Observación No Participante (AEIOU)
El objetivo fue evaluar en tiempo real la usabilidad, el rendimiento técnico y la respuesta de los usuarios frente a los procesos críticos del Marketplace[cite: 662].

* [cite_start]**Actividades:** Registro legal en el SII, carga manual de stock, monitoreo de notificaciones de nuevos pedidos y coordinación directa con el cliente[cite: 682].
* [cite_start]**Entornos:** Uso de dispositivos móviles personales en espacios de trabajo con conexiones a internet inestables[cite: 682].
* **Interacciones:** Contacto directo entre emprendedor y cliente post-compra, solicitudes de soporte técnico con Flow y calificación mutua[cite: 682].
* [cite_start]**Objetos:** Computadores o smartphones, comprobantes de inicio de actividades, pasarela Flow y hosting AWS[cite: 682].
* [cite_start]**Usuarios:** Emprendedores con diversos niveles de alfabetización digital, clientes vecinos de la comuna y administradores[cite: 685, 686, 687].

---

## 5 Categorización y Priorización de Insights
* **Acceso y Formalización:** El registro en el SII es una "espada de doble filo": entrega seguridad al cliente, pero complica al vendedor informal[cite: 743, 751].
* [cite_start]**Brecha Digital:** Los emprendedores prefieren procesos manuales para sentir control real sobre su stock y dinero ante la desconfianza de lo automático[cite: 743, 753].
* [cite_start]**Estabilidad del Sistema:** Un sitio web lento o con errores de carga destruye la confianza del cliente, siendo percibido como un servicio poco serio[cite: 743, 750].
* **Viabilidad Económica:** Pagar una mensualidad sin ventas aseguradas se percibe como una apuesta de alto riesgo para el presupuesto familiar del vecino[cite: 743, 752].

---

## 6 Redefinición del Desafío y Conclusión
**Desafío redefinido:** ¿De qué manera podríamos optimizar la experiencia de comercio segura y eficiente para emprendedores en proceso de formalización, reduciendo la complejidad y promoviendo un camino confiable y accesible en la etapa inicial de adopción del marketplace en Puente Alto? [cite: 913]

**Conclusión clave:** El éxito de la plataforma requiere la mitigación de dos barreras críticas: la fricción administrativa que genera la exigencia de formalización ante el SII y la alta brecha digital predominante en el segmento de usuarios objetivo[cite: 918]. Técnicamente, la arquitectura actual es coherente para la etapa de MVP, pero la optimización de consultas a la base de datos y el balanceo de carga en AWS serán factores críticos de éxito para escalar a más de 500 usuarios concurrentes diarios[cite: 921, 922].

<br>

# Informe 2: Ideación de Propuestas

**Tecnologías de la Información y Ciberseguridad | [cite_start]Inacap** [cite: 1, 2]

* **Nombres:** Bryan Alegría, Diego Aránguiz, Romina Baeza, Elisa Oyarzun y Cristina Sepúlveda [cite: 4]
* [cite_start]**Carrera:** Ingeniería en Informática [cite: 4]
* [cite_start]**Asignatura:** Innovación y emprendimiento [cite: 5]
* **Profesor:** Yaleni Gómez [cite: 6]
* [cite_start]**Fecha:** 20 de mayo 2026 [cite: 7]

---

## 1 Introducción
[cite_start]En la Unidad 2 de Innovación y Emprendimiento se desarrolló un proceso de análisis e ideación enfocado en la creación de una solución tecnológica capaz de responder a problemáticas reales presentes en la comunidad[cite: 16]. [cite_start]El objetivo principal es optimizar la experiencia de comercio seguro y eficiente para los emprendedores de Puente Alto, reduciendo la complejidad tecnológica y promoviendo un entorno accesible y confiable[cite: 18]. [cite_start]Para abordar este desafío, se utilizaron distintas herramientas metodológicas, tales como fichas de referentes, matrices, tabla de requerimientos, mapas de categorías, canvas brainstorming, panel de metáforas e identificación de ODS[cite: 23].

---

## 2 Matriz y Fichas de Referentes
[cite_start]El equipo analizó plataformas existentes para rescatar buenas prácticas y elementos inspiradores[cite: 219, 429]:

| Caso | Modelo de Negocio | Gestión de Pagos | Facilidad de Uso | Nivel de Formalidad | Elementos Inspiradores |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **Shopify** | [cite_start]SaaS basado en suscripción mensual y servicios cloud [cite: 219] | [cite_start]Shopify Payments, Stripe y PayPal con seguridad PCI DSS [cite: 219] | [cite_start]Media-Alta con dashboard React intuitivo [cite: 219] | [cite_start]Alta [cite: 219] | [cite_start]APIs modulares, automatización, microservicios y panel administrativo [cite: 219] |
| **Mercado Libre** | [cite_start]Comisión por venta y servicios premium [cite: 219] | [cite_start]Mercado Pago con IA antifraude [cite: 219] | [cite_start]Media-Alta con UX optimizada y logistica integrada [cite: 219] | [cite_start]Alta [cite: 219] | [cite_start]Sistema reputacional, tracking, pagos seguros y arquitectura distribuida [cite: 219] |
| **Facebook Marketplace** | [cite_start]Gratuito con monetización publicitaria [cite: 219] | [cite_start]Coordinación directa y Meta Pay [cite: 219] | [cite_start]Alta por simplicidad y acceso móvil [cite: 219] | [cite_start]Baja [cite: 219] | [cite_start]Comunicación inmediata, integración social y facilidad de publicación [cite: 219] |
| **AliExpress** | [cite_start]Comisión por venta internacional B2C [cite: 219] | [cite_start]AliPay y pagos internacionales con escrow [cite: 219] | [cite_start]Media con comparadores y tracking global [cite: 219] | [cite_start]Alta [cite: 219] | [cite_start]Comercio internacional, seguimiento logístico y catálogo masivo [cite: 219] |
| **Amazon Marketplace** | [cite_start]Comisión, suscripción y servicios premium [cite: 219] | [cite_start]Sistema centralizado AWS con antifraude IA [cite: 219] | [cite_start]Alta mediante personalización inteligente [cite: 219] | [cite_start]Muy Alta [cite: 219] | [cite_start]IA, automatización logística, experiencia UX y arquitectura cloud [cite: 219] |

---

## 3 Tabla de Requerimientos
* **Insight 1 (Formalización):** El sistema debe simplificar el proceso de formalización, implementar onboarding guiado y validar la información legal del vendedor para generar confianza[cite: 232, 233, 234].
* [cite_start]**Insight 2 (Brecha Digital):** La interfaz debe implementar principios UX/UI orientados a baja alfabetización digital, ser responsive y permitir que el vendedor gestione manualmente su stock[cite: 236, 237, 239].
* [cite_start]**Insight 3 (Rendimiento):** El sistema debe mantener tiempos de carga rápidos, usar infraestructura escalable con monitoreo básico y soportar múltiples usuarios simultáneos[cite: 242, 243, 244, 246].
* **Insight 4 (Sostenibilidad):** El modelo de pago debe ser accesible, existir un período gratuito de marcha blanca y la plataforma debe demostrar beneficios rápidamente[cite: 248, 252, 253].

---

## 4 Metáfora y Atributos de la Propuesta
**Metáfora:** "Es como la feria libre de la plaza de Puente Alto, pero en tu celular: un espacio digital donde el trato es directo, la plata pasa mano a mano sin intermediarios, pero con el respaldo de una infraestructura formalizada, rápida y segura"[cite: 349].

* [cite_start]**Trato Directo (Gestión Intuitiva):** Interfaz basada en Dokan diseñada para ser sencilla, permitiendo el control manual de stock y pagos directos vía Flow[cite: 357, 358].
* [cite_start]**Formalización Acompañada:** Proceso de onboarding que guía en la validación ante el SII, transformando el trámite en un filtro de confianza[cite: 364, 365].
* **Estabilidad de Cemento (Rendimiento):** Infraestructura escalable en Amazon Web Services (AWS) que asegura alta disponibilidad y evita la percepción de "servicio poco serio"[cite: 368, 369].
* [cite_start]**Crecimiento sin Riesgo:** Etapa de "marcha blanca" gratuita que permite validar la plataforma mitigando el riesgo financiero inicial[cite: 371].

---

## 5 Alineación de Idea a un Enfoque Sostenible ODS
* [cite_start]**ODS 8 (Trabajo decente y crecimiento económico):** Permite comercializar productos de manera formal y accesible, no cobrando comisiones por venta durante la etapa inicial[cite: 378, 380].
* **ODS 10 (Reducción de las desigualdades):** Busca disminuir brechas de acceso al comercio digital para emprendedores con menos recursos o escasa experiencia tecnológica[cite: 385].
* [cite_start]**ODS 11 (Ciudades y comunidades sostenibles):** Fortalece el comercio de cercanía y el desarrollo económico local, incentivando el consumo responsable en Puente Alto[cite: 391, 392].

---

## 6 Conclusión
[cite_start]El proceso iterativo permitió descartar funciones tecnológicas de alta complejidad (como integraciones nativas o desarrollos de Inteligencia Artificial) en favor de alternativas altamente factibles y de alto impacto[cite: 403]. [cite_start]Se consolidó un diseño de Producto Mínimo Viable (MVP) basado en tecnologías de código abierto (WordPress y Dokan) y en la optimización de recursos gratuitos (AWS Free Tier), lo que garantiza el cumplimiento del desafío sin exceder las limitaciones presupuestarias[cite: 404]. [cite_start]Las ideas seleccionadas aseguran que la plataforma priorice la usabilidad y la generación de confianza para lograr la adopción temprana durante la futura marcha blanca[cite: 408].