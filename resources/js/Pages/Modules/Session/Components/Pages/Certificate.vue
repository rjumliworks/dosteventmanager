<template>
    <div class="flex items-center justify-center min-h-screen bg-gray-100">
        <div ref="certificate" class="certificate m-4 mt-5 bg-certificate">
            <!-- Background -->
            <div class="m-5">
                <img class="absolute top-0 left-0 w-full h-full object-cover mt-5" />

                <div class="d-flex">
                    <div class="flex-shrink-0 ms-5">
                        <img src="/images/dost.png" style="width: 120px; height: auto;">
                    </div>
                    <div class="flex-grow-1 ms-2">
                        <p class="fs-17 mb-0 mt-4">Republic of the Philippines</p>
                        <p class="fs-20 fw-semibold mt-n1 mb-0">DEPARTMENT OF SCIENCE AND TECHNOLOGY</p>
                        <p class="fs-17 mt-n1">Regional Office IX</p>
                    </div>
                    <div class="flex-shrink-0 me-5">
                        <img src="/images/bagongpilipinas.png" style="width: 120px; height: auto; margin-top: -10px;">
                    </div>
                </div>
                <br /><br />
                <h1 class="fw-semibold text-dark text-center mt-5">CERTIFICATE OF APPEARANCE</h1>

                <h4 class="text-justify mx-auto text-center mt-5" style="max-width: 80%; font-size: 18px; line-height: 1.4;">
                    This is to certify that <b class="text-uppercase text-primary fs-19"><ins>Mr. Ra-ouf I. Jumli</ins></b> of <b class="text-uppercase text-primary fs-19"><ins>Department of Science and Technology - IX</ins></b> Appeared at DOST IX Office on August 27, 2025 to inquired about DOST Technologies
                </h4>
                <br />

                <p class="text-justify mx-auto text-center mt-4" style="max-width: 80%; font-size: 14px; line-height: 1.4;">
                    This certification is issued in compliance with the standing regulations provided under 
                    <strong>Republic Act No. 3847</strong>, duly implemented by <strong>COA Circular No. 127</strong>, 
                    for the purpose of establishing the evidence and duration of his/her appearance hereto.  
                    The truth of which is hereby vouchsafed and guaranteed by the undersigned.
                </p>

                <p class="text-justify mx-auto text-center mt-4" style="max-width: 80%; font-size: 14px; line-height: 1.4;">
                    Issued this <b>8th day of August 2025</b> in Zamboanga City, Philippines.
                </p>

                 <div class="d-flex">
                    <div class="flex-shrink-0 ms-5">
                       
                    </div>
                    <div class="flex-grow-1 ms-2">
                       
                    </div>
                   <div class="flex-shrink-0 me-5 text-center mt-5">
                        <h3 class="fw-semibold text-dark fs-22 mt-5">JENNIFER A. PIDOR</h3>
                        <p class="fs-15 mt-n2">OIC - Regional Director</p>
                    </div>
                </div>


            </div>
        </div>
    </div>
  

  <button @click="downloadPDF" class="mt-4 bg-blue-500 text-white px-4 py-2 rounded">
    Download Half A4 Certificate
  </button>
</template>
<script>
import html2canvas from "html2canvas";
import jsPDF from "jspdf";
export default {
    methods: {
        renderValue(key) {
            switch (key) {
                case "participant_name":
                return this.participant.name;
                case "event_name":
                return this.participant.session.event.name;
                case "date":
                return this.participant.session.event.date;
                default:
                return "";
            }
        },
       async downloadPDF() {
      const element = this.$refs.certificate;

      const canvas = await html2canvas(element, { scale: 2 });
      const imgData = canvas.toDataURL("image/png");

      const pdf = new jsPDF("l", "px", [element.offsetWidth, element.offsetHeight]);
      pdf.addImage(imgData, "PNG", 0, 0, element.offsetWidth, element.offsetHeight);
      pdf.save("certificate.pdf");
    }
    }
}
</script>
<style scoped>
.certificate {
  position: relative;
  width: 1123px; /* A4 landscape size ratio */
  height: 794px;
  background-color:white;
}
</style>