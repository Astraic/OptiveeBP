using Microsoft.AspNetCore.Mvc;
using Microsoft.Extensions.Logging;
using MLWebAPIML.Model;
using System;
using System.Text.Json;
using System.Web.Script.Serialization;

namespace MLWebAPI.Controllers
{
    [ApiController]
    public class ProductionController : ControllerBase
    {

        private readonly ILogger<ProductionController> _logger;

        public ProductionController(ILogger<ProductionController> logger)
        {
            _logger = logger;
        }

        [HttpGet]
        [Route("api/[controller]")]
        public float Get()
        {
            ModelInput data = JsonSerializer.Deserialize<ModelInput>(Request.Query["json"]);

            data.Date = DateTime.Now.ToString("dd/mm/yyyy HH:mm:ss");
            data.Productiondatetime = DateTime.Now.AddDays(1).ToString("dd/mm/yyyy HH:mm:ss");
            // Make a single prediction on the sample data and print results
            ModelOutput predictionResult = ConsumeModel.Predict(data);
            return (Int32) predictionResult.Score;
        }
    }
}
