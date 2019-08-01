---
description: Instalación de la tarjeta de red wifi de portátil HP para Linux Ubuntu 18.04
---

# Instalación de wifi Realtek en portátil con Linux

![Wifi]({{BASE_IMG}}logo/wifi.png)

Estas instrucciones sirven para instalar y hacer funcionar las tarjetas Realtek wifi de la lista:

- rtl8188ee
- rtl8192c, rtl8192ce, rtl8192cu, rtl8192de, rtl8192ee, rtl8192se, 
- rtl8723ae, rtl8723be, rtl8723com, rtl8723de
- rtl8821ae
- rtl8822be

Puedes encontrar toda esta información en inglés en la página oficial de los [drivers Realtek](https://github.com/lwfinger/rtlwifi_new/)

## Mi caso de éxito

Compré un ordenador portátil HP que tenía *Windows* preinstalado. Quité el sistema operativo de *Microsoft* e
instalé Linux Ubuntu 18.04. Me di cuenta de que la tarjeta wifi Realtek no funcionaba correctamente, así 
que investigue y no encontré información en Español. Aquí comparto los pasos que llevé a cabo para resolverlo.

He instalado los drivers de mi tarjeta de red *rtl8723de* siguiendo los pasos abajo indicados. Instalar
una tarjeta de la lista de arriba debe ser parecido, pero cambiando el modelo.

- Accede al terminal de Linux
- Descarga los drivers mediante

```bash
git clone https://github.com/lwfinger/rtlwifi_new
```

- A continuación entra en el directorio donde se ha descargado el código fuente, en este casi suele ser `rtlwifi_new` y compílalo con

```bash
make
```

- Ahora instálalo con los permisos de administador

```bash
sudo make install
```

- Finalmente inicializa el driver el el ordenador con

```bash
sudo modprobe -v rtl8723de ant_sel=2
```

En este caso, el parámetro `ant_sel=2` lo uso porque de lo contrario la señal que se recibe mi antena de wifi es
débil. Algunas antenas wifi podrían recibir la señal con suficiente intensidad desde el primer momento así que no sería
necesario. De todas formas, si lo necesitas, para hacer esta configuración de antena permanente puedes escribir

```bash
sudo echo "options rtl8723de ant_sel=2" > /etc/modprobe.d/50-rtl8723de.conf
```

Pero recuerda que el parámentro `ant_sel=2` solo es imprescindible si tu antena de wifi no recibe la señal
con suficiente intensidad. Para saber si es tu caso puedes escribir en el terminal

```bash
DEVICE=$(iw dev | grep Interface | cut -d " " -f2)
```

y luego

```bash
sudo iw dev $DEVICE scan | egrep "SSID|signal|\(on"
```

Si la señal de tu wifi es inferior a $-60$ entonces es que tu tarjeta no recibe la señal bien y tu red funcionaría lenta
o incluso puede que se llegue a perder la señal.

#wifi #realtek #ubuntu #linux #driver
