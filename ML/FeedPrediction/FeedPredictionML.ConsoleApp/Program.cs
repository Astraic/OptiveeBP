// This file was auto-generated by ML.NET Model Builder. 

using System;
using FeedPredictionML.Model;

namespace FeedPredictionML.ConsoleApp
{
    class Program
    {
        static void Main(string[] args)
        {
            // Create single instance of sample data from first line of dataset for model input
            ModelInput sampleData = new ModelInput()
            {
                Animal = @"19165ed7-212e-21c4-0428-030d4265475f",
                Feedid = 4F,
            };

            // Make a single prediction on the sample data and print results
            var predictionResult = ConsumeModel.Predict(sampleData);

            Console.WriteLine("Using model to make single prediction -- Comparing actual Production with predicted Production from sample data...\n\n");
            Console.WriteLine($"Animal: {sampleData.Animal}");
            Console.WriteLine($"Feedid: {sampleData.Feedid}");
            Console.WriteLine($"\n\nPredicted Production: {predictionResult.Score}\n\n");
            Console.WriteLine("=============== End of process, hit any key to finish ===============");
            Console.ReadKey();
        }
    }
}
