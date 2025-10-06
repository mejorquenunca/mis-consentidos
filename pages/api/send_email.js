import dotenv from 'dotenv';
dotenv.config({ path: '.env.local' }); // <--- Carga forzada del archivo

import nodemailer from 'nodemailer';

export default async function handler(req, res) {
  if (req.method !== 'POST') {
    return res.status(405).json({ error: 'Método no permitido' });
  }

  const { nombre, email, telefono, mensaje } = req.body;

  const transporter = nodemailer.createTransport({
    host: process.env.SMTP_HOST,
    port: process.env.SMTP_PORT,
    secure: false,
    auth: {
      user: process.env.SMTP_USER,
      pass: process.env.SMTP_PASS,
    },
    tls: {
    rejectUnauthorized: false
  }
  });

  try {
    await transporter.sendMail({
      from: `"Mis Consentidos" <${process.env.SMTP_USER}>`,
      to: process.env.SMTP_USER,
      subject: `Nuevo mensaje de ${nombre}`,
      text: `
        Nombre: ${nombre}
        Correo: ${email}
        Teléfono: ${telefono}
        Mensaje: ${mensaje}
      `,
      html: `
        <h3>Nuevo mensaje desde el formulario</h3>
        <p><strong>Nombre:</strong> ${nombre}</p>
        <p><strong>Correo:</strong> ${email}</p>
        <p><strong>Teléfono:</strong> ${telefono}</p>
        <p><strong>Mensaje:</strong> ${mensaje}</p>
      `,
    });

    return res.status(200).json({ success: true, message: '¡Correo enviado con éxito!' });
  } catch (error) {
    console.error("Error al enviar correo:", error);
    return res.status(500).json({ success: false, message: 'Error al enviar el correo' });
  }
}

