using Microsoft.AspNetCore.Http;
using Microsoft.AspNetCore.Mvc;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;
using Microsoft.Extensions.ML;
using FeedPrediction.DataModel;

namespace FeedPrediction.Controllers
{
    [Route("api/[controller]")]
    [ApiController]
    public class PredictController : ControllerBase
    {

        private readonly PredictionEnginePool<ModelInput, ModelOutput> _predictionEnginePool;

        public PredictController(PredictionEnginePool<ModelInput, ModelOutput> predictionEnginePool)
        {
            _predictionEnginePool = predictionEnginePool;
        }

        [HttpPost]
        public ActionResult<float> Post([FromBody] ModelInput modelInput)
        {
            if (!ModelState.IsValid)
            {
                return BadRequest();
            }

            ModelOutput prediction = _predictionEnginePool.Predict(modelName: "FeedAnalysisModel", example: modelInput);

            float production = prediction.Score;

            return Ok(production);
        }

    }
}
